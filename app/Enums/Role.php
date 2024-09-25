<?php

namespace App\Enums;

enum Role: string
{
    case SUPER_ADMIN = 'super_admin';
    case STORE_OWNER = 'store_owner';
    case CUSTOMER = 'customer';
    case DELIVERY_MAN = 'delivery_man';
    case FITTER_MAN = 'fitter_man';
}
