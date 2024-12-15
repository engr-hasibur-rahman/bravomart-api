<?php

namespace App\Interfaces;
interface AreaManageInterface
{
    public function getAreas(array $filters);
    public function setArea(array $data);
    public function getAreaById(int $id);
    public function updateAreaById(array $data);
    public function deleteArea(int $id);
}