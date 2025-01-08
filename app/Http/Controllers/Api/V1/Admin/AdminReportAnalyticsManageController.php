<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminReportAnalyticsManageController extends Controller
{
    public function reportList(Request $request){
        $reports = [
            'transaction_report' => 'Transaction Report Data',
            'item_report' => 'Item Report Data',
            'store_wise_report' => 'Store Wise Report Data',
            'expense_report' => 'Expense Report Data',
            'disbursement_report' => 'Disbursement Report Data',
            'order_report' => 'Order Report Data',
        ];

        // Optional: Filter by report type if specified in the request
        $reportType = $request->get('type');
        if ($reportType && isset($reports[$reportType])) {
            return response()->json([
                'message' => ucfirst(str_replace('_', ' ', $reportType)),
                'data' => $reports[$reportType],
            ]);
        }

        // Default: Return all reports
        return response()->json([
            'message' => 'Admin Report Analytics Index',
            'reports' => array_keys($reports),
        ]);
    }
}
