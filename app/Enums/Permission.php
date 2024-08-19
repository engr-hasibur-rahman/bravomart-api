<?php

namespace App\Enums;

enum Permission
{
    public const SUPER_ADMIN = 'super_admin';
    public const STORE_OWNER = 'store_owner';
    public const STAFF = 'staff';
    public const CUSTOMER = 'customer';
    public const DELIVERY_MAN = 'delivery_man';
    public const FITTER_MAN = 'fitter_man';
}
