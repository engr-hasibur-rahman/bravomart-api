<?php

namespace App\Interfaces;
interface InventoryRepositoryInterface
{
 public function getInventories(array $filters);
}
