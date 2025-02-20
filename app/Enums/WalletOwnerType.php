<?php

namespace App\Enums;

enum WalletOwnerType: string
{
    case STORE = 'App\Models\Store';
    case DELIVERYMAN = 'App\Models\DeliveryMan';
    case CUSTOMER = 'App\Models\Customer';
}