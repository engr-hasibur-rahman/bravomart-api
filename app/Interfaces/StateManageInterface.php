<?php

namespace App\Interfaces;
interface StateManageInterface
{
    public function getStates(array $filters);

    public function setState(array $data);

    public function getStateById(int $id);

    public function updateStateById(array $data);

    public function deleteState(int $id);
}
