<?php

namespace App\Console\Commands;

use App\Enums\PermissionKey as UserPermission;
use App\Enums\Role as UserRole;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\{text, confirm, info, error, table};

class BivaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biva:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installing Biva Dependencies';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info('Installing Biva Dependencies...');
        info('If you have already run this command or migrated tables then be aware.');
        info('Do you want to seed dummy data?');
        

        info('Please use arrow key for navigation.');
        if (confirm('Are you sure!')) {

            $this->clearDemoData();

            info('Tables Migration completed.');

            info('Importing required settings...');

            $this->call('db:seed');

            info('Settings import is completed.');
        } 

        elseif (confirm('Do you want to migrate fresh your database!')){
            $this->call('migrate:fresh');
        }
        else {
            info('Do you want to seed dummy Settings data?');
            info('If "yes", then please follow next steps carefully.');
            if (confirm('Are you sure!')) {
                $this->call('biva:setting-seed');
            }
        }

        $this->call('biva:create-admin'); // creating Admin



        // $this->modifySettingsData();



        info('Everything is successful. Now clearing all cached...');
        $this->call('optimize:clear');
        info('Thank You.');
    }

    public function clearDemoData()
    {
        info('If Yes! then it will erase all of your data.');
        info('And seeding all data from sql files.');
        if (confirm('Are you sure! ')) {

            info('Dropping all tables started...');
            $this->call('migrate:fresh');
            info('Dropping all tables ended...');

            info('Database seeding started...');
            $this->seedDemoData();
            
            info('Database seeding completed.');
            return 0;
        }
    }
    public function seedDemoData()
    {
        info('Copying necessary files for seeding....');

        (new Filesystem)->copyDirectory(config('sql-seeder.sql_file_path'), public_path('sql'));
        
        info('File copying successful');
        
        info('Seeding....');

        $get_sql_files_path = (new Filesystem)->files(public_path('sql'));
        foreach($get_sql_files_path as $key => $path){
            $file_sql = file_get_contents($path);
            DB::statement($file_sql);
        }
        info('Seed completed successfully!');
    }
}
