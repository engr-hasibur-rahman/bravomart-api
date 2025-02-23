<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface AdminDashboardManageInterface
{
    public function getSummaryData();

    public function getSalesSummaryData(array $filters);

    public function getOtherSummaryData();
}