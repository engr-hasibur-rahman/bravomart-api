<?php

namespace App\Repositories;

use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Product\ProductDetailsPublicResource;
use App\Http\Resources\Product\RelatedProductPublicResource;
use App\Http\Resources\Product\TopRatedProductPublicResource;
use App\Interfaces\AdminDashboardManageInterface;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardManageRepository implements AdminDashboardManageInterface
{
    public function __construct(protected User $user)
    {

    }

    /* <-------------------------------------------------------- User Analytics Start --------------------------------------------------------> */
    public function getSummaryData()
    {
        $total_store = Store::count();
        $total_seller = User::where('store_owner', 1)->count();
        $total_order = Order::count();
        $total_product = Product::count();
        $total_customer = Customer::count();
        $total_stuff = User::where('activity_scope', 'store_level')
            ->where('store_owner', '!=', 1)
            ->count();
        $pending_orders = Order::where('status', 'pending')->count();
        $completed_orders = Order::where('status', 'delivered')->count();
        $cancelled_orders = Order::where('status', 'cancelled')->count();
        $deliveryman_not_assigned_orders = Order::where('status', 'processing')->whereNull('confirmed_by')->count();
        $refunded_orders = Order::where('refund_status', 'refunded')->count();
        return [
            'total_store' => $total_store,
            'total_seller' => $total_seller,
            'total_product' => $total_product,
            'total_order' => $total_order,
            'total_customer' => $total_customer,
            'total_stuff' => $total_stuff,
            'pending_orders' => $pending_orders,
            'completed_orders' => $completed_orders,
            'cancelled_orders' => $cancelled_orders,
            'deliveryman_not_assigned_orders' => $deliveryman_not_assigned_orders,
            'refunded_orders' => $refunded_orders
        ];
    }


    public function getSalesSummaryData(array $filters)
    {
        $query = Order::query();

        if (!empty($filters['this_week'])) {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
        } elseif (!empty($filters['this_month'])) {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif (!empty($filters['this_year'])) {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        } elseif (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $startDate = Carbon::parse($filters['start_date'])->startOfDay();
            $endDate = Carbon::parse($filters['end_date'])->endOfDay();
        }

        if (isset($startDate) && isset($endDate)) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $query
            ->where('status', 'delivered')
            ->selectRaw('DATE(created_at) as date, SUM(order_amount) as total_sales')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function getOtherSummaryData()
    {
        $topRatedProducts = $this->getTopRatedProducts();

        $topSellingStores = $this->getTopSellingStores();

        $recentCompletedOrders = $this->getRecentCompletedOrders();

        return [
            'top_rated_products' => $topRatedProducts,
            'top_selling_stores' => $topSellingStores,
            'recent_completed_orders' => $recentCompletedOrders,
        ];
    }

    public function getTopRatedProducts()
    {
        return Product::with(['variants', 'store'])
            ->where('products.status', 'approved')
            ->whereNull('products.deleted_at')
            ->leftJoin('reviews', function ($join) {
                $join->on('products.id', '=', 'reviews.reviewable_id')
                    ->where('reviews.reviewable_type', '=', Product::class)
                    ->where('reviews.status', '=', 'approved');
            })
            ->select([
                'products.id',
                'products.name',
                'products.slug',
                'products.image',
                'products.store_id',
                'products.status',
                DB::raw('COALESCE(AVG(reviews.rating), 0) as avg_rating')
            ])
            ->groupBy([
                'products.id',
                'products.name',
                'products.slug',
                'products.image',
                'products.store_id',
                'products.status'
            ])
            ->orderByDesc('avg_rating')
            ->limit(5)
            ->get();
    }

    public function getTopSellingStores()
    {
        return Order::with('store')
            ->where('status', 'delivered')
            ->selectRaw('store_id, SUM(order_amount) as total_sales')
            ->groupBy('store_id')
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get();
    }

    public function getRecentCompletedOrders()
    {
        return Order::with(['orderMaster.customer', 'orderDetail', 'orderMaster', 'store', 'deliveryman', 'orderMaster.shippingAddress'])
            ->where('status', 'delivered')
            ->orderByDesc('delivery_completed_at')
            ->limit(5)
            ->get();
    }
    /* <-------------------------------------------------------- User Analytics End --------------------------------------------------------> */
}
