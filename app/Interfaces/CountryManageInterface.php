<?php

namespace App\Interfaces;
interface CountryManageInterface
{
    public function getCountries(array $filters);

    public function setCountry(array $data);

    public function getCountryById(int $id);

    public function updateCountryById(array $data);
    public function deleteCountry(int $id);
}
