<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\{text,  confirm, info};

class SettingSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biva:setting-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create setting data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('setting_options')->truncate();
        $this->call('db:seed');
         if (DB::table('settings')->where('id', 1)->exists()) {

             if (confirm('Already data exists. Do you want to refresh it with dummy settings?')) {

                 info('Seeding necessary settings....');

                 DB::table('settings')->truncate();

                 info('Importing dummy settings...');

                 $this->call('db:seed');

                 info('Settings were imported successfully');
             } else {
                 info('Previous settings was kept. Thanks!');
             }
         } else {
             info('Seeding necessary settings....');

             DB::table('settings')->truncate();

             info('Importing dummy settings...');

             $this->call('db:seed');

             info('Settings were imported successfully');
         }
    }
}
