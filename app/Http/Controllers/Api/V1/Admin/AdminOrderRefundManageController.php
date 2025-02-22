<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\OrderRefundInterface;
use Illuminate\Http\Request;

class AdminOrderRefundManageController extends Controller
{
    public function __construct(protected OrderRefundInterface $orderRefundRepo)
    {

    }

    public function createOrderRefundReason(Request $request)
    {

    }
}
