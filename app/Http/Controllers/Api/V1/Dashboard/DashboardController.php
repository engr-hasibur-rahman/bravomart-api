<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\SummaryResource;
use App\Interfaces\AdminDashboardManageInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected AdminDashboardManageInterface $adminRepo)
    {

    }

    public function loadSummaryData()
    {
        $data = $this->adminRepo->getSummaryData();
        return response()->json(new SummaryResource((object)$data));
    }
}
