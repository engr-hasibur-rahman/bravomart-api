<?php

namespace App\Http\Controllers\Api\V1\Deliveryman;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\DeliverymanDashboardResource;
use App\Interfaces\DeliverymanManageInterface;
use Illuminate\Http\Request;

class DeliverymanDashboardController extends Controller
{
    public function __construct(protected DeliverymanManageInterface $deliverymanRepo)
    {

    }

    public function dashboard()
    {
        $data = $this->deliverymanRepo->getDeliverymanDashboard();
        return response()->json(new DeliverymanDashboardResource((object)$data));
    }
}
