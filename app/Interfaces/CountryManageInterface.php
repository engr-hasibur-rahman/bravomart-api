<?php

namespace App\Interfaces;
interface CountryManageInterface
{
    public function getCountries(array $filters);
    public function setCountry(array $data);
}
