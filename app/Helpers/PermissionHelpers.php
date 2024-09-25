<?php

use App\Enums\Role;

function getPermissionMiddleware(string $permission = ''): string
{
    logger($permission);
    // TODO: Have to remove the AP permission from here
    return ($permission && array_key_exists($permission, config('middleware')))
        ? 'permission:' . implode('|', config('middleware.' . $permission))
        : 'role:' . Role::SUPER_ADMIN->value;
}