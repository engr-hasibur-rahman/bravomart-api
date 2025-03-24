<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exports\OrderReportExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminOrderReportResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

        $query = OrderDetail::query();

        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('order_id', 'LIKE', '%' . $filters['search'] . '%')
                    ->orWhere('invoice_number', 'LIKE', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['type'])) {
            $query->whereHas('store', function ($q) use ($filters) {
                $q->where('type', $filters['type']);
            });
        }

        if (isset($filters['area_id'])) {
            $query->where('area_id', $filters['area_id']);
        }

        if (isset($filters['payment_gateway'])) {
            $query->whereHas('order.orderMaster', function ($q) use ($filters) {
                $q->where('payment_gateway', $filters['payment_gateway']);
            });
        }

        if (isset($filters['payment_status'])) {
            $query->whereHas('order.orderMaster', function ($q) use ($filters) {
                $q->where('payment_status', $filters['payment_status']);
            });
        }

        if (isset($filters['order_status'])) {
            $query->whereHas('order', function ($q) use ($filters) {
                $q->where('status', $filters['order_status']);
            });
        }

        if (isset($filters['store_id'])) {
            $query->where('store_id', $filters['store_id']);
        }

        if (isset($filters['customer_id'])) {
            $query->whereHas('order.orderMaster', function ($q) use ($filters) {
                $q->where('customer_id', $filters['customer_id']);
            });
        }

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereHas('order', function ($q) use ($filters) {
                $q->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
            });
        } elseif (isset($filters['start_date'])) {
            $query->whereHas('order', function ($q) use ($filters) {
                $q->whereDate('created_at', '>=', $filters['start_date']);
            });
        } elseif (isset($filters['end_date'])) {
            $query->whereHas('order', function ($q) use ($filters) {
                $q->whereDate('created_at', '<=', $filters['end_date']);
            });
        }

        $orderDetails = $query->with(['order.orderMaster.customer','order.orderMaster', 'store', 'area'])
            ->latest()
            ->paginate($filters['per_page'] ?? 20);
        // Check if export option is requested (either csv or xlsx)
        if ($request->has('export') && in_array($request->export, ['csv', 'xlsx'])) {
            // Export to CSV or XLSX using the filtered data
            return Excel::download(new OrderReportExport($orderDetails), 'order_report_' . time() . '.' . $request->export);
        }

        return response()->json([
            'data' => AdminOrderReportResource::collection($orderDetails),
            'meta' => new PaginationResource($orderDetails)
        ]);
    }

}
