<?php

namespace App\Interfaces;

interface ProductAuthorInterface 
{
    public function getPaginatedAuthor(int|string $limit,string $search, string $sortField, string $sort);
    public function store(array $data);
    public function update(array $data);
    public function getAuthorById(int|string $id);
    public function delete(int|string $id);
    public function changeStatus(array $data);
}