<?php

namespace App\Interfaces;
interface CityManageInterface
{
    public function getCities(array $filters);
    public function setCity(array $data);
    public function getCityById(int $id);
    public function updateCityById(array $data);
    public function deleteCity(int $id);
}
