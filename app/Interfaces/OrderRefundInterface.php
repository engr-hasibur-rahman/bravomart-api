<?php

namespace App\Interfaces;
interface OrderRefundInterface
{
    public function create_order_refund_reason(array $data);
}