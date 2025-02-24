<?php

namespace App\Http\Controllers\Api\V1\Deliveryman;

use App\Http\Controllers\Controller;
use App\Interfaces\DeliverymanManageInterface;
use Illuminate\Http\Request;

class DeliverymanDashboardController extends Controller
{
    public function __construct(protected DeliverymanManageInterface $deliverymanRepo)
    {

    }

    public function dashboard()
    {

    }
}
