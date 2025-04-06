<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\AdminOtherSummaryResource;
use App\Http\Resources\Dashboard\OrderGrowthSummaryResource;
use App\Http\Resources\Dashboard\SalesSummaryResource;
use App\Http\Resources\Dashboard\SummaryResource;
use App\Interfaces\AdminDashboardManageInterface;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct(protected AdminDashboardManageInterface $adminRepo)
    {

    }

    public function summaryData()
    {
        $data = $this->adminRepo->getSummaryData();
        return response()->json(new SummaryResource((object)$data));
    }

    public function salesSummaryData(Request $request)
    {
        $filters = [
            "this_week" => $request->this_week,
            "this_month" => $request->this_month,
            "this_year" => $request->this_year,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
        ];
        $data = $this->adminRepo->getSalesSummaryData($filters);
        return response()->json(new SalesSummaryResource($data));
    }
    public function orderGrowthData()
    {
        $data = $this->adminRepo->getOrderGrowthData();
        return response()->json(new OrderGrowthSummaryResource($data));
    }

    public function otherSummaryData()
    {
        $data = $this->adminRepo->getOtherSummaryData();
        return response()->json(new AdminOtherSummaryResource((object)$data));
    }
}
