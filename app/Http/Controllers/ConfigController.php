<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ConfigController extends Controller
{
    // Example: Get application config values
    public function index()
    {
        // You can customize this to return any config or settings you want
        return response()->json([
            'app_name' => config('app.name'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
        ]);
    }

    // Download database backup as SQL file
    public function downloadBackup()
    {
        // Generate a unique filename
        $fileName = 'backup_' . date('Y_m_d_His') . '.sql';
        $storagePath = storage_path('app/' . $fileName);

        // Hardcoded credentials
        $username = 'root';
        $password = 'inF!n1ty';
        $host     = '127.0.0.1';
        $database = 'torems_be';

        $optionFile = 'D:\\BIT Project 2024\\Project\\TOREMS_BE\\mysql_backup.cnf';
        // Build the mysqldump command (password in double quotes for special chars)
        $command = sprintf(
            'mysqldump --defaults-extra-file=%s %s > %s',
            escapeshellarg($optionFile),
            escapeshellarg($database),
            escapeshellarg($storagePath)
        );

        // Run the mysqldump command
        $result = null;
        $output = null;
        exec($command . ' 2>&1', $output, $result);
        \Log::info('Backup command: ' . $command);
        \Log::info('Backup output: ' . print_r($output, true));
        if ($result !== 0) {
            return response()->json(['error' => 'Backup failed', 'details' => $output], 500);
        }

        // Return the file as a download response
        return response()->download($storagePath)->deleteFileAfterSend(true);
    }
}