<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\TrackingSubscription;

class CheckTracking extends Command
{
    protected $signature = 'tracking:check';
    protected $description = 'Check tracking updates and send FCM';

    public function handle()
    {
        $subs = TrackingSubscription::all();

        if ($subs->isEmpty()) {
            Log::info('TRACKING_EMPTY');
            return 0;
        }

        Log::info('TRACKING_START', [
            'count' => $subs->count(),
            'at' => now()->toDateTimeString(),
        ]);

        foreach ($subs as $sub) {
            Log::info('TRACKING_SUB', [
                'id' => $sub->id ?? null,
                'codigo' => $sub->codigo,
                'token_prefix' => $sub->fcm_token ? substr($sub->fcm_token, 0, 20) : null,
                'last_sig' => $sub->last_sig,
            ]);

            try {
                $resp = Http::timeout(15)
                    ->withoutVerifying()
                    ->withToken(env('TRACKING_API_TOKEN'))
                    ->post(env('TRACKING_API_URL'), [
                        'codigo' => $sub->codigo,
                    ]);
            } catch (\Throwable $e) {
                Log::error('TRACKING_API_EX', [
                    'codigo' => $sub->codigo,
                    'msg' => $e->getMessage(),
                ]);
                continue;
            }

            Log::info('TRACKING_API', [
                'codigo' => $sub->codigo,
                'status' => $resp->status(),
                'ok' => $resp->ok(),
                'content_type' => $resp->header('Content-Type'),
                'body' => $resp->body(),
            ]);

            if (!$resp->ok()) {
                continue;
            }

            $data = $resp->json();
            if (!is_array($data)) {
                Log::warning('TRACKING_JSON_INVALID', [
                    'codigo' => $sub->codigo,
                    'body' => $resp->body(),
                ]);
                continue;
            }

            $locales = $data['eventos_locales'] ?? [];
            $externos = $data['eventos_externos'] ?? [];

            Log::info('TRACKING_COUNTS', [
                'codigo' => $sub->codigo,
                'locales' => is_array($locales) ? count($locales) : null,
                'externos' => is_array($externos) ? count($externos) : null,
            ]);

            $sig = $this->latestSignature($locales, $externos);

            Log::info('TRACKING_LATEST', [
                'codigo' => $sub->codigo,
                'computed_sig' => $sig,
            ]);

            if (!$sig) {
                Log::warning('TRACKING_NO_SIG', ['codigo' => $sub->codigo]);
                continue;
            }

            Log::info('TRACKING_SIG', [
                'codigo' => $sub->codigo,
                'prev' => $sub->last_sig,
                'new' => $sig,
            ]);

            $latest = $this->latestEventData($locales, $externos, $sig);

            if ($sub->last_sig === null) {
                $sub->last_sig = $sig;
                $sub->save();

                Log::info('TRACKING_INIT', [
                    'codigo' => $sub->codigo,
                    'saved' => $sig,
                    'notified' => true,
                ]);

                $this->sendFcmSafe(
                    $sub->fcm_token,
                    $sub->codigo,
                    $latest,
                    $sub->package_name ?? null
                );

                continue;
            }

            if ($sub->last_sig !== $sig) {
                $old = $sub->last_sig;

                $sub->last_sig = $sig;
                $sub->save();

                Log::info('TRACKING_CHANGED', [
                    'codigo' => $sub->codigo,
                    'from' => $old,
                    'to' => $sig,
                ]);

                $this->sendFcmSafe(
                    $sub->fcm_token,
                    $sub->codigo,
                    $latest,
                    $sub->package_name ?? null
                );
            } else {
                Log::info('TRACKING_NO_CHANGE', [
                    'codigo' => $sub->codigo,
                ]);
            }
        }

        Log::info('TRACKING_DONE', [
            'at' => now()->toDateTimeString(),
        ]);

        return 0;
    }

    private function latestSignature($locales, $externos)
    {
        $items = [];

        foreach (($locales ?? []) as $ev) {
            $date = $ev['updated_at'] ?? $ev['created_at'] ?? null;
            if ($date) {
                $ts = strtotime($date);
                if ($ts !== false) {
                    $items[] = [
                        'ts' => $ts,
                        'sig' => 'local|' . $date . '|'
                            . ($ev['id'] ?? '') . '|'
                            . ($ev['action'] ?? '') . '|'
                            . ($ev['descripcion'] ?? ''),
                    ];
                }
            }
        }

        foreach (($externos ?? []) as $ev) {
            $date = $ev['eventDate'] ?? null;
            if ($date) {
                $ts = strtotime($date);
                if ($ts !== false) {
                    $items[] = [
                        'ts' => $ts,
                        'sig' => 'external|' . $date . '|'
                            . ($ev['mailitM_PID'] ?? '') . '|'
                            . ($ev['eventType'] ?? '') . '|'
                            . ($ev['office'] ?? ''),
                    ];
                }
            }
        }

        if (!count($items)) return null;

        usort($items, fn($a, $b) => $b['ts'] <=> $a['ts']);

        return $items[0]['sig'];
    }

    private function latestEventData($locales, $externos, $sig = '')
    {
        $items = [];

        foreach (($locales ?? []) as $ev) {
            $date = $ev['updated_at'] ?? $ev['created_at'] ?? null;
            if ($date) {
                $ts = strtotime($date);
                if ($ts !== false) {
                    $items[] = [
                        'ts' => $ts,
                        'data' => [
                            'source' => 'local',
                            'eventDate' => $date,
                            'eventTitle' => $ev['action'] ?? 'Evento local',
                            'eventBody' => $ev['descripcion'] ?? '',
                            'office' => '',
                            'condition' => '',
                            'nextOffice' => '',
                            'sig' => $sig,
                        ],
                    ];
                }
            }
        }

        foreach (($externos ?? []) as $ev) {
            $date = $ev['eventDate'] ?? null;
            if ($date) {
                $ts = strtotime($date);
                if ($ts !== false) {
                    $items[] = [
                        'ts' => $ts,
                        'data' => [
                            'source' => 'external',
                            'eventDate' => $date,
                            'eventTitle' => $ev['eventType'] ?? 'Evento externo',
                            'eventBody' => '',
                            'office' => $ev['office'] ?? '',
                            'condition' => $ev['condition'] ?? '',
                            'nextOffice' => $ev['nextOffice'] ?? '',
                            'sig' => $sig,
                        ],
                    ];
                }
            }
        }

        if (!count($items)) return [];

        usort($items, fn($a, $b) => $b['ts'] <=> $a['ts']);

        return $items[0]['data'];
    }

    private function sendFcmSafe($token, $codigo, array $latest = [], ?string $packageName = null)
    {
        if (!$token) {
            Log::warning('FCM_SKIP_NO_TOKEN', ['codigo' => $codigo]);
            return;
        }

        Log::info('FCM_SEND', [
            'codigo' => $codigo,
            'token_prefix' => substr($token, 0, 20),
        ]);

        try {
            $this->sendFcm($token, $codigo, $latest, $packageName);
        } catch (\Throwable $e) {
            Log::error('FCM_EX', [
                'codigo' => $codigo,
                'msg' => $e->getMessage(),
            ]);
        }
    }

    private function sendFcm($token, $codigo, array $latest = [], ?string $packageName = null)
    {
        $name = trim((string)($packageName ?: $codigo));
        $eventText = trim((string)(
            ($latest['eventBody'] ?? '') !== ''
                ? $latest['eventBody']
                : ($latest['eventTitle'] ?? 'Se detecto un nuevo movimiento')
        ));

        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => 'Nuevo evento de TrackingBo',
                    'body'  => "Nombre: {$name}\nCodigo: {$codigo}\nEvento nuevo: {$eventText}",
                ],
                'data' => [
                    'codigo'       => (string)$codigo,
                    'packageName'  => (string)$name,
                    'eventSource'  => (string)($latest['source'] ?? ''),
                    'eventDate'    => (string)($latest['eventDate'] ?? ''),
                    'eventTitle'   => (string)($latest['eventTitle'] ?? ''),
                    'eventBody'    => (string)($latest['eventBody'] ?? ''),
                    'office'       => (string)($latest['office'] ?? ''),
                    'condition'    => (string)($latest['condition'] ?? ''),
                    'nextOffice'   => (string)($latest['nextOffice'] ?? ''),
                    'highlightSig' => (string)($latest['sig'] ?? ''),
                    'type'         => 'tracking_update',
                ],
                'android' => [
                    'priority' => 'HIGH',
                    'notification' => [
                        'channel_id' => 'default',
                        'sound' => 'default',
                    ],
                ],
            ],
        ];

        $accessToken = $this->getAccessToken();

        $resp = Http::withToken($accessToken)
            ->post('https://fcm.googleapis.com/v1/projects/' . env('FIREBASE_PROJECT_ID') . '/messages:send', $payload);

        Log::info('FCM_STATUS', [
            'codigo' => $codigo,
            'status' => $resp->status(),
            'body' => $resp->body(),
        ]);

        if (in_array($resp->status(), [404, 410], true)) {
            TrackingSubscription::where('fcm_token', $token)->delete();
            Log::warning('FCM_TOKEN_DELETED', [
                'codigo' => $codigo,
                'status' => $resp->status(),
            ]);
        }

        if ($resp->failed()) {
            Log::warning('FCM_FAILED', [
                'codigo' => $codigo,
                'status' => $resp->status(),
            ]);
        }
    }

    private function getAccessToken()
    {
        $client = new \Google_Client();
        $client->setAuthConfig(storage_path('app/firebase-service-account.json'));
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        $token = $client->fetchAccessTokenWithAssertion();

        if (!is_array($token) || empty($token['access_token'])) {
            Log::error('FCM_ACCESS_TOKEN_FAIL', [
                'token' => $token,
            ]);
            throw new \RuntimeException('No se pudo obtener access_token para FCM');
        }

        return $token['access_token'];
    }
}
