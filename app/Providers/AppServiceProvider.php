<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Validator;
use Illuminate\Support\Facades\Gate;
use App\Models\User; // Importa la clase User correcta

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrap();
        Validator::extend('captcha', function ($attribute, $value, $parameters, $validator) {
            $recaptcha = new \ReCaptcha\ReCaptcha(config('services.recaptcha.secret'));
            $response = $recaptcha->verify($value, $_SERVER['REMOTE_ADDR']);

            return $response->isSuccess();
        });

        Gate::define('viewPulse', function (?User $user) {
            return $user !== null;
        });

        // 🔒 Agrega HttpOnly a XSRF-TOKEN (opcional, si NO lo usas con JavaScript)
        app('router')->middleware('web')->group(function () {
            app('events')->listen('Illuminate\Routing\Events\RouteMatched', function () {
                $token = csrf_token();
    
                Cookie::queue(
                    new SymfonyCookie(
                        'XSRF-TOKEN',
                        $token,
                        now()->addMinutes(config('session.lifetime')),
                        '/',
                        null,
                        config('session.secure'),
                        true, // HttpOnly
                        false,
                        'Lax'
                    )
                );
            });
        });
    }
}
