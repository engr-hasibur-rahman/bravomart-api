<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface OrderRefundInterface
{
    public function order_refund_list(array $filters);

    public function create_order_refund_reason(string $reason);

    public function get_order_refund_reason_by_id(int $id);

    public function update_order_refund_reason(array $data);

    public function delete_order_refund_reason(int $id);

    public function createOrUpdateTranslation(Request $request, int|string $refid, string $refPath, array $colNames);

    public function create_order_refund_request(int $order_id, array $data);
}