<?php

namespace App\Enums;

enum StoreType: string
{
    case GROCERY = 'grocery';
    case BAKERY = 'bakery';
    case MEDICINE = 'medicine';
    case MAKEUP = 'makeup';
    case BAGS = 'bags';
    case CLOTHING = 'clothing';
    case FURNITURE = 'furniture';
    case BOOKS = 'books';
    case GADGET = 'gadgets';
    case ANIMALS_PET = 'animals-pet' ;
    case FISH = 'fish';
}
