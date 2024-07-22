<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class BackupController extends Controller
{
    public function backup()
    {
        $dbHost = env('DB_HOST');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');

        $backupFile = storage_path('app/backups/' . $dbName . '_' . date('Y-m-d_H-i-s') . '.sql');

        $command = sprintf(
            'mysqldump --host=%s --user=%s --password=%s %s > %s',
            escapeshellarg($dbHost),
            escapeshellarg($dbUser),
            escapeshellarg($dbPass),
            escapeshellarg($dbName),
            escapeshellarg($backupFile)
        );

        $process = Process::fromShellCommandline($command);

        try {
            $process->mustRun();
            
            return response()->download($backupFile)->deleteFileAfterSend(true);

        } catch (ProcessFailedException $exception) {
            return redirect()->back()->with('error', 'Backup failed: ' . $exception->getMessage());
        }
    }
}
