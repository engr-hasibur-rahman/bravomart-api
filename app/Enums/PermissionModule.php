<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum PermissionModule: string
{
    use InvokableCases;
    use Values;

    case GENERAL = 'general';
    case PRODUCT = 'product';
    case OTHERS = 'others';
}
