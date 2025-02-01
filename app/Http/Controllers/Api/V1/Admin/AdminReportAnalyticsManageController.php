<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminReportAnalyticsManageController extends Controller
{
    public function reportList(Request $request)
    {
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

    public function orderReport(Request $request)
    {
        $filters = [
            'type' => $request->type,
            'area_id' => $request->area_id,
            'payment_gateway' => $request->payment_gateway,
            'payment_status' => $request->payment_status,
            'order_status' => $request->order_status,
            'store_id' => $request->store_id,
            'customer_id' => $request->customer_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'search' => $request->search,
            'per_page' => $request->per_page
        ];

        $query = Order::query();

        if (isset($filters['search'])) {
            $query->where('id', $filters['search']);
        }

        if (isset($filters['type'])) {
            $query->whereHas('order_details.store', function ($q) use ($filters) {
                $q->where('type', $filters['type']);
            });
        }

        if (isset($filters['area_id'])) {
            $query->whereHas('order_details', function ($q) use ($filters) {
                $q->where('area_id', $filters['area_id']);
            });
        }

        if (isset($filters['payment_gateway'])) {
            $query->where('payment_gateway', $filters['payment_gateway']);
        }

        if (isset($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if (isset($filters['order_status'])) {
            $query->where('status', $filters['order_status']);
        }

        if (isset($filters['store_id'])) {
            $query->whereHas('order_details', function ($q) use ($filters) {
                $q->where('store_id', $filters['store_id']);
            });
        }

        if (isset($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        } elseif (isset($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        } elseif (isset($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        $orders = $query->with(['order_details'])->latest()->paginate($filters['per_page'] ?? 20);

        return response()->json($orders);
    }

}
