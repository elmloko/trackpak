<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Validator;
use Illuminate\Support\Facades\Gate;
use App\Models\User; // Importa la clase User correcta
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;
use Illuminate\Support\Facades\Response;

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
    }
}
