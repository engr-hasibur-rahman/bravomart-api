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
    case ANIMALS_PET = 'animals-pet';
    case FISH = 'fish';

    public static function images(): array
    {
        return [
            self::GROCERY->value => asset('asset/grocery.jpg'),
            self::BAKERY->value => 'https://example.com/images/electronics.png',
            self::MEDICINE->value => 'https://example.com/images/fashion.png',
            self::MAKEUP->value => 'https://example.com/images/fashion.png',
            self::BAGS->value => 'https://example.com/images/fashion.png',
            self::CLOTHING->value => 'https://example.com/images/fashion.png',
            self::BOOKS->value => 'https://example.com/images/fashion.png',
            self::GADGET->value => 'https://example.com/images/fashion.png',
            self::ANIMALS_PET->value => 'https://example.com/images/fashion.png',
            self::FISH->value => 'https://example.com/images/fashion.png',
        ];
    }

    public function image(): string
    {
        return self::images()[$this->value] ?? 'https://example.com/images/default.png';
    }
}

