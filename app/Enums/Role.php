<?php

namespace App\Enums;

enum Role: string
{
    case SUPER_ADMIN = 'system_level';
    case STORE_OWNER = 'store_level';
    case CUSTOMER = 'customer';
    case DELIVERY_MAN = 'delivery_man';
    case FITTER_MAN = 'fitter_man';
}
