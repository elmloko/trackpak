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

        foreach ($subs as $sub) {
            Log::info('TRACKING_SUB', [
                'codigo' => $sub->codigo,
                'token' => substr($sub->fcm_token, 0, 20),
            ]);

           $resp = Http::timeout(15)
    ->withoutVerifying()
    ->withToken(env('TRACKING_API_TOKEN'))
    ->post(env('TRACKING_API_URL'), [
        'codigo' => $sub->codigo
    ]);


            Log::info('TRACKING_API', [
                'codigo' => $sub->codigo,
                'status' => $resp->status(),
                'ok' => $resp->ok(),
                'body' => $resp->ok() ? null : $resp->body(),
            ]);

            if (!$resp->ok()) continue;

            $data = $resp->json();
            $locales = $data['eventos_locales'] ?? [];
            $externos = $data['eventos_externos'] ?? [];

            $sig = $this->latestSignature($locales, $externos);
            if (!$sig) continue;

            Log::info('TRACKING_SIG', [
                'codigo' => $sub->codigo,
                'prev' => $sub->last_sig,
                'new' => $sig,
            ]);

            if ($sub->last_sig === null) {
                $sub->last_sig = $sig;
                $sub->save();
                continue;
            }

            if ($sub->last_sig !== $sig) {
                $sub->last_sig = $sig;
                $sub->save();
                $this->sendFcm($sub->fcm_token, $sub->codigo);
            }
        }

        return 0;
    }

    private function latestSignature($locales, $externos)
    {
        $all = array_merge($locales ?? [], $externos ?? []);
        if (!count($all)) return null;

        usort($all, function ($a, $b) {
            return strtotime($b['eventDate'] ?? $b['created_at'] ?? '1970-01-01')
                <=> strtotime($a['eventDate'] ?? $a['created_at'] ?? '1970-01-01');
        });

        $last = $all[0];
        return ($last['eventDate'] ?? $last['created_at'] ?? '') . '|' .
               ($last['eventType'] ?? $last['action'] ?? '') . '|' .
               ($last['office'] ?? '') . '|' .
               ($last['condition'] ?? '') . '|' .
               ($last['nextOffice'] ?? '');
    }

    private function sendFcm($token, $codigo)
    {
        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => 'Nuevo evento de tracking',
                    'body' => "Actualización para: {$codigo}",
                ],
            ],
        ];

        $resp = Http::withToken($this->getAccessToken())
            ->post('https://fcm.googleapis.com/v1/projects/'.env('FIREBASE_PROJECT_ID').'/messages:send', $payload);

        Log::info('FCM_STATUS', [
            'status' => $resp->status(),
            'body' => $resp->body(),
        ]);

        if ($resp->status() === 404 || $resp->status() === 410) {
            TrackingSubscription::where('fcm_token', $token)->delete();
        }
    }

    private function getAccessToken()
    {
        $client = new \Google_Client();
        $client->setAuthConfig(storage_path('app/firebase-service-account.json'));
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $token = $client->fetchAccessTokenWithAssertion();
        return $token['access_token'];
    }
}
