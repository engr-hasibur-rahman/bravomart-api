<?php
//
//namespace App\Console\Commands;
//
//use Illuminate\Console\Command;
//use Spatie\Permission\Models\Permission;
//use Spatie\Permission\Models\Role;
//
//class RoleDataSeed extends Command
//{
//    /**
//     * The name and signature of the console command.
//     *
//     * @var string
//     */
//    protected $signature = 'roledataseed';
//
//    /**
//     * The console command description.
//     *
//     * @var string
//     */
//    protected $description = 'Seed roles, permissions, and relationships between models.';
//
//
//    /**
//     * Execute the console command.
//     */
//    public function handle()
//    {
//        $this->call('db:seed', ['--class' => 'RolesSeeder']);
//        $this->call('db:seed', ['--class' => 'PermissionAdminSeeder']);
//        $this->call('db:seed', ['--class' => 'PermissionStoreSeeder']);
//
//        // After seeding roles and permissions, assign permissions to roles
//        $this->givePermissionTo();
//
//        // Then seed the role assignments
//        $this->call('db:seed', ['--class' => 'ModelHasRolesSeeder']);
//
//        $this->info('Role, Permission, and Model relationships seeded successfully.');
//    }
//
//    protected function assignPermissionsToRoles()
//    {
//        // Check if permissions exist before assignment
//        $adminPermissions = Permission::whereIn('name', ['admin_permission_1', 'admin_permission_2'])->get();
//        $storePermissions = Permission::whereIn('name', ['store_permission_1', 'store_permission_2'])->get();
//
//        // Assign permissions to roles
//        $adminRole = Role::findByName('admin');
//        if ($adminRole && $adminPermissions->count() > 0) {
//            $adminRole->givePermissionTo($adminPermissions);
//        }
//
//        $storeRole = Role::findByName('store');
//        if ($storeRole && $storePermissions->count() > 0) {
//            $storeRole->givePermissionTo($storePermissions);
//        }
//
//        // Add more roles and permissions as needed
//    }
//}
