<?php

namespace App\Interfaces;
interface  AddressManageInterface
{
    public function setAddress(array $data);

    public function handleDefaultAddress(array $data);
    public function getAddress(?int $id, ?string $type, int $status);
}