<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class BackupThenReinsertDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:thenreinsert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Backup the database using the package
        $this->info('Starting database backup...');

        $backupPath = storage_path('app/database_backups');
        $timestamp = Carbon::now()->format('Y_m_d_His');
        $backupFile = $backupPath . "/backup_{$timestamp}.zip";

        // Run the backup using the spatie package
        Artisan::call('backup:run', [
            '--only-db' => true,
            '--disable-notifications' => true
        ]);

        $this->info('Database backup completed successfully.');

      // run other command
        // Run the next command - biva:autoinstall
        $this->info('Starting Biva auto install...');
        Artisan::call('biva:autoinstall');
        $this->info('Biva auto install completed successfully.');
    }
}
