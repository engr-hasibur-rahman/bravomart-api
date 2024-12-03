<?php

namespace App\Enums;

enum Behaviour: string
{
    case PRODUCT = 'product';
    case CONSUMABLE = 'consumable';
    case COMBO = 'combo';
    case SERVICE = 'service';
}
