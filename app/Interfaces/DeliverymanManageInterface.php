<?php

namespace App\Interfaces;
interface DeliverymanManageInterface
{

<<<<<<< HEAD
    public function update(array $data);

    public function getAllDeliveryman(array $filters);

    public function getDeliverymanById(int $id);

    public function delete(int $userId);

    public function getDeliverymanRequests();

    public function approveDeliverymen(array $deliveryman_ids);
    public function changeStatus(array $data);

    public function getAllVehicles(array $filters);

    public function getVehicleRequests();

    public function approveVehicles(array $ids);

    public function toggleVehicleStatus(int $id);

    public function addVehicle(array $data);

    public function updateVehicle(array $data);

    public function getVehicleById(int $id);

    public function deleteVehicle(int $id);

    public function storeTranslation(Request $request, int|string $refid, string $refPath, array $colNames);

    public function updateTranslation(Request $request, int|string $refid, string $refPath, array $colNames);
=======
>>>>>>> ec6cc7008589409b3537ffebcadc27707c435a26
}
