<?php

namespace App\Enums;

enum StatusType: string
{
    case GROCERY = 'draft';
    case BAKERY = 'pending';
    case MEDICINE = 'approved';
    case MAKEUP = 'inactive';
    case BAGS = 'suspended';
}
