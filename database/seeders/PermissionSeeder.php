<?php

namespace Database\Seeders;

use App\Enums\Permission;
use App\Enums\PermissionModule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission as ModelsPermission;
use function PHPUnit\Framework\throwException;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {

        $modules_permissions = [
            PermissionModule::GENERAL->value => [
                Permission::ALL->value,
            ],
            PermissionModule::PRODUCT->value => [
                Permission::ADD_PRODUCT->value,
                Permission::EDIT_PRODUCT->value,
            ],
            PermissionModule::OTHERS->value => [
                Permission::MANAGE_CONFIGURATIONS->value,
            ]
        ];
        $total_permission_count_in_enum = count(Permission::values());
        $total_permission_count_in_array = 0;
        $copy_permissions = [];


        foreach ($modules_permissions as $module => $permissions) {
            foreach ($permissions as $permission) {
                $total_permission_count_in_array++;
                $copy_permissions[] = $permission;
                ModelsPermission::updateOrCreate(
                    ['name' => $permission, 'guard_name' => 'api'],
                    ['name' => $permission, 'guard_name' => 'api', 'module' => $module]
                );
            }
        }

        if ($total_permission_count_in_enum != $total_permission_count_in_array) {
            $missed_permissions = array_diff(Permission::values(), $copy_permissions);
            logger('Permission missing', ['missed_permissions' => $missed_permissions]);
            logger()->error('Permission count mismatch', ['enum' => $total_permission_count_in_enum, 'array' => $total_permission_count_in_array]);
            throw new \Exception('Permission count mismatch');
        }
        logger('Seeding Permissions Completed');
    }
}
