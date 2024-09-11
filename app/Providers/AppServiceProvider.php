<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Validator;
use Illuminate\Support\Facades\Gate
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\App;;
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
        if (App::environment('local')) {
            // Lista de comandos que quieres deshabilitar en producción
            $restrictedCommands = [
                'migrate:fresh',
                'migrate:reset',
                'db:wipe',
            ];

            Artisan::command($restrictedCommands, function () {
                $this->error("Este comando está deshabilitado en producción.");
            })->describe('Comando deshabilitado en producción.');
        }
    }
}
