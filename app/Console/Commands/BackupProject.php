<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class BackupProject extends Command
{
    /**
     * Nombre y firma del comando
     *
     * @var string
     */
    protected $signature = 'backup:project';

    /**
     * Descripción del comando
     *
     * @var string
     */
    protected $description = 'Genera un backup del proyecto Laravel y de la base de datos MySQL en un archivo RAR (Windows) o ZIP (Linux)';

    /**
     * Ejecutar el comando
     */
    public function handle()
    {
        // Aumentar el tiempo máximo de ejecución a 10 minutos
        ini_set('max_execution_time', 600);

        // Crear la carpeta de backups si no existe
        $backupPath = storage_path('app/backups');
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        // Generar timestamp
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');

        // Rutas de los archivos
        $dbBackupFile = "{$backupPath}/db_backup_{$timestamp}.sql";
        $rarFile = "{$backupPath}/backup_{$timestamp}.rar";
        $zipFile = "{$backupPath}/backup_{$timestamp}.zip";

        // Configuración de la base de datos
        $dbHost = config('database.connections.mysql.host');
        $dbPort = config('database.connections.mysql.port');
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');

        // Detectar sistema operativo
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

        // Generar el backup de la base de datos
        if ($isWindows) {
            $mysqlDumpCommand = "mysqldump -h {$dbHost} -P {$dbPort} -u {$dbUser} " .
                (!empty($dbPass) ? "-p'{$dbPass}' " : "") .
                "{$dbName} > " . escapeshellarg($dbBackupFile);
        } else {
            $mysqlDumpCommand = "mysqldump --host=" . escapeshellarg($dbHost) .
                " --port=" . escapeshellarg($dbPort) .
                " --user=" . escapeshellarg($dbUser) .
                (!empty($dbPass) ? " --password=" . escapeshellarg($dbPass) : "") .
                " " . escapeshellarg($dbName) .
                " > " . escapeshellarg($dbBackupFile);
        }

        // Ejecutar el backup de la base de datos
        exec($mysqlDumpCommand, $output, $returnVar);

        if ($returnVar !== 0) {
            $this->error("Error al generar el backup de la base de datos.");
            $this->error(implode("\n", $output));
            return Command::FAILURE;
        }

        // Crear backup del proyecto y base de datos en RAR o ZIP
        $projectPath = base_path();

        if ($isWindows) {
            // Windows - Usar WinRAR para comprimir
            $rarCommand = "rar a -r \"{$rarFile}\" \"{$projectPath}\\\" -x\"{$projectPath}\\storage\\app\\backups\\\"";
            exec($rarCommand, $rarOutput, $rarReturnVar);

            if ($rarReturnVar !== 0) {
                $this->error("Error al generar el backup en RAR.");
                $this->error(implode("\n", $rarOutput));
                return Command::FAILURE;
            }

            // Agregar la base de datos al RAR
            $addDbToRarCommand = "rar a \"{$rarFile}\" \"{$dbBackupFile}\"";
            exec($addDbToRarCommand);
        } else {
            // Linux - Usar ZIP
            $zipCommand = "cd \"{$projectPath}\" && zip -r \"{$zipFile}\" . -x \"storage/app/backups/*\"";
            exec($zipCommand, $zipOutput, $zipReturnVar);

            if ($zipReturnVar !== 0) {
                $this->error("Error al generar el backup en ZIP.");
                $this->error(implode("\n", $zipOutput));
                return Command::FAILURE;
            }

            // Agregar la base de datos al ZIP
            $addDbToZipCommand = "zip -j \"{$zipFile}\" \"{$dbBackupFile}\"";
            exec($addDbToZipCommand);
        }

        // Eliminar el archivo SQL después de agregarlo al backup
        unlink($dbBackupFile);

        $this->info("Backup generado correctamente: " . ($isWindows ? $rarFile : $zipFile));

        return Command::SUCCESS;
    }
}
