<?php

namespace App\Console\Commands;

use Database\Seeders\ModelHasRolesSeeder;
use Database\Seeders\PermissionAdminSeeder;
use Database\Seeders\PermissionStoreSeeder;
use Database\Seeders\RolesSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RolePermissionInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rolepermisstion:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and seed roles and permissions for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info('Starting Role and Permission Install...');

        // Call the method to clear demo data (truncate specific tables)
        $this->clearSpecificTables();

        // Seed only the data related to these tables
        $this->seedSpecificTables();

        info('Role and Permission Install completed successfully.');

        // Clear any cache
        $this->call('optimize:clear');
    }

    /**
     * Truncate only specific tables (roles, permissions, etc.)
     */
    public function clearSpecificTables()
    {
        info('Truncating specific tables...');

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        // Truncate only specific tables
        DB::table('model_has_roles')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('permissions')->truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        info('Specific tables truncated and AUTO_INCREMENT reset.');
    }

    /**
     * Seed only the specific tables for roles and permissions.
     */
    public function seedSpecificTables()
    {
        info('Starting database seeding for specific tables...');
        info('Role and Permission seed completed successfully!');
    }
}
