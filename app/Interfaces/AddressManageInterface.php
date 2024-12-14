<?php

namespace App\Interfaces;
interface  AddressManageInterface
{
    public function setAddress(array $data);

    public function handleDefaultAddress(array $data);
    public function getAddress(?string $id, ?string $type, ?string $status);
}