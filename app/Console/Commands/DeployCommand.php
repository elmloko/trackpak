<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DeployCommand extends Command
{

    protected $signature = 'deploy';

    protected $description = 'Despliega la última versión de la aplicación desde Git y actualiza la aplicación en producción';

    public function handle()
    {
        // Lista de comandos a ejecutar
        $commands = [
            'git pull origin main', // o 'master', según tu rama principal
            'php artisan optimize:clear'
        ];

        foreach ($commands as $cmd) {
            $this->info("Ejecutando: {$cmd}");

            // Creamos el proceso
            $process = Process::fromShellCommandline($cmd, base_path());
            $process->run();

            // Si el comando falla, detenemos el proceso
            if (!$process->isSuccessful()) {
                $this->error("Error al ejecutar: {$cmd}");
                $this->error($process->getErrorOutput());
                return 1;
            } else {
                $this->info($process->getOutput());
            }
        }

        $this->info("Despliegue completado exitosamente.");

        return 0;
    }
}
