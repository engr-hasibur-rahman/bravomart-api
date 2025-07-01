<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RefreshDemoDatabase extends Command
{
    protected $signature = 'bravo:refresh-database';
    protected $description = 'Refresh the database with the demo SQL file';

    public function handle(): int
    {
        $sqlPath = base_path('database/bravo_fresh.sql');

        if (!File::exists($sqlPath)) {
            $this->error("SQL file not found at: {$sqlPath}");
            return Command::FAILURE;
        }

        try {
            $this->dropAllTables();

            $sql = File::get($sqlPath);

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Use DB::unprepared to run entire SQL file at once
            DB::unprepared($sql);

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $this->info('✅ Demo database refreshed successfully using SQL file.');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Error while refreshing database: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    protected function dropAllTables(): void
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = DB::getDatabaseName();
        $key = "Tables_in_{$dbName}";

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($tables as $table) {
            DB::statement('DROP TABLE IF EXISTS `' . $table->$key . '`');
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('✅ All existing tables dropped.');
    }
}
