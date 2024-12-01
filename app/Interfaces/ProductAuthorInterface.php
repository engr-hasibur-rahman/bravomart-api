<?php

namespace App\Interfaces;

interface ProductAuthorInterface 
{
    public function getPaginatedAuthor(int|string $limit,string $search, string $sortField, string $sort);
}