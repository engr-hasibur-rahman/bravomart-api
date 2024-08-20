<?php

namespace App\Console\Commands;

use App\Enums\Permission as UserPermission;
use App\Enums\Role as UserRole;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
            $this->call('dewan:sql-seed');

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

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::firstOrCreate(['name' => UserPermission::SUPER_ADMIN]);
        Permission::firstOrCreate(['name' => UserPermission::CUSTOMER]);
        Permission::firstOrCreate(['name' => UserPermission::STORE_OWNER]);
        Permission::firstOrCreate(['name' => UserPermission::STAFF]);
        Permission::firstOrCreate(['name' => UserPermission::DELIVERY_MAN]);
        Permission::firstOrCreate(['name' => UserPermission::FITTER_MAN]);

        $superAdminPermissions = [UserPermission::SUPER_ADMIN, UserPermission::STORE_OWNER, UserPermission::CUSTOMER];
        $storeOwnerPermissions = [UserPermission::STORE_OWNER, UserPermission::CUSTOMER];
        $staffPermissions      = [UserPermission::STAFF, UserPermission::CUSTOMER];
        $customerPermissions   = [UserPermission::CUSTOMER];
        $customerPermissions   = [UserPermission::DELIVERY_MAN];
        $customerPermissions   = [UserPermission::FITTER_MAN];

        Role::firstOrCreate(['name' => UserRole::SUPER_ADMIN])->syncPermissions($superAdminPermissions);
        Role::firstOrCreate(['name' => UserRole::STORE_OWNER])->syncPermissions($storeOwnerPermissions);
        Role::firstOrCreate(['name' => UserRole::STAFF])->syncPermissions($staffPermissions);
        Role::firstOrCreate(['name' => UserRole::CUSTOMER])->syncPermissions($customerPermissions);
        Role::firstOrCreate(['name' => UserRole::DELIVERY_MAN])->syncPermissions($customerPermissions);
        Role::firstOrCreate(['name' => UserRole::FITTER_MAN])->syncPermissions($customerPermissions);

        $this->call('biva:create-admin'); // creating Admin



        // $this->modifySettingsData();



        info('Everything is successful. Now clearing all cached...');
        $this->call('optimize:clear');
        info('Thank You.');
    }
}
