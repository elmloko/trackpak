<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use illuminate\Pagination\Paginator;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Validator::extend('captcha', function ($attribute, $value, $parameters, $validator) {
            $recaptcha = new \ReCaptcha\ReCaptcha(config('services.recaptcha.secret'));
            $response = $recaptcha->verify($value, $_SERVER['REMOTE_ADDR']);

            return $response->isSuccess();
        });
    }
}
