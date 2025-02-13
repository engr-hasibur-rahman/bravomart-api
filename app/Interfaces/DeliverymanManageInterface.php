<?php

namespace App\Interfaces;


use Illuminate\Support\Facades\Request;

interface DeliverymanManageInterface
{

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

    public function deliverymanOrders();

    public function orderRequests();

    public function updateOrderStatus(string $status, int $order_id, string $reason);

    public function deliverymanOrderHistory();

    public function deliverymanListDropdown(array $filter);

    public function storeTranslation(Request $request, int|string $refid, string $refPath, array $colNames);

    public function updateTranslation(Request $request, int|string $refid, string $refPath, array $colNames);
}
