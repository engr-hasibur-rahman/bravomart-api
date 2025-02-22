<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface OrderRefundInterface
{
    public function order_refund_reason_list(array $filters);

    public function approve_refund_request(int $id, string $status);

    public function reject_refund_request(int $id, string $status);

    public function refunded_refund_request(int $id, string $status);

    public function get_order_refund_request(array $filters);

    public function get_seller_store_order_refund_request(int $store_id, array $filters);

    public function create_order_refund_reason(string $reason);

    public function get_order_refund_reason_by_id(int $id);

    public function update_order_refund_reason(array $data);

    public function delete_order_refund_reason(int $id);

    public function createOrUpdateTranslation(Request $request, int|string $refid, string $refPath, array $colNames);

    public function create_order_refund_request(int $order_id, array $data);
}