<?php

namespace App\Interfaces;
interface CustomerManageInterface
{
    public function register(array $data);
    public function getToken(array $data);
}