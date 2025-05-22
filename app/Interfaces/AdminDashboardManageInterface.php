<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface AdminDashboardManageInterface
{
    public function getSummaryData(?int $store_id);

    public function getSalesSummaryData(array $filters);

    public function getOtherSummaryData();

    public function getOrderGrowthData();
}