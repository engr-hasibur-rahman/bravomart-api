<?php

namespace App\Enums;

enum Behaviour: string
{
    case CONSUMABLE = 'consumable';
    case SERVICE = 'service';
    case PRODUCT = 'digital';
    case COMBO = 'combo';

}
