<?php

namespace App\Repositories;

use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Product\ProductDetailsPublicResource;
use App\Http\Resources\Product\RelatedProductPublicResource;
use App\Http\Resources\Product\TopRatedProductPublicResource;
use App\Interfaces\AdminDashboardManageInterface;
use App\Models\Blog;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Page;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\Slider;
use App\Models\Store;
use App\Models\Product;
use App\Models\StoreArea;
use App\Models\Ticket;
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
        $total_staff = User::where('activity_scope', 'store_level')
            ->where('store_owner', '!=', 1)
            ->count();
        $pending_orders = Order::where('status', 'pending')->count();
        $completed_orders = Order::where('status', 'delivered')->count();
        $cancelled_orders = Order::where('status', 'cancelled')->count();
        $deliveryman_not_assigned_orders = Order::where('status', 'processing')->whereNull('confirmed_by')->count();
        $refunded_orders = Order::where('refund_status', 'refunded')->count();
        $total_areas = StoreArea::count();
        $total_deliverymen = User::where('activity_scope', 'delivery_level')->count();
        $total_categories = ProductCategory::count();
        $total_brands = ProductBrand::count();
        $total_sliders = Slider::count();
        $total_coupons = Coupon::count();
        $total_pages = Page::count();
        $total_blogs = Blog::count();
        $total_tickets = Ticket::count();
        return [
            'total_customers' => $total_customer,
            'total_sellers' => $total_seller,
            'total_stores' => $total_store,
            'total_products' => $total_product,
            'total_deliverymen' => $total_deliverymen,
            'total_areas' => $total_areas,
            'total_categories' => $total_categories,
            'total_brands' => $total_brands,
            'total_sliders' => $total_sliders,
            'total_coupons' => $total_coupons,
            'total_pages' => $total_pages,
            'total_blogs' => $total_blogs,
            'total_tickets' => $total_tickets,
            'total_staff' => $total_staff,

            'total_orders' => $total_order,
            'total_pending_orders' => $pending_orders,
            'total_confirmed_orders' => $pending_orders,
            'total_processing_orders' => $pending_orders,
            'total_shipped_orders' => $pending_orders,
            'total_delivered_orders' => $completed_orders,
            'total_cancelled_orders' => $cancelled_orders,
            'deliveryman_not_assigned_orders' => $deliveryman_not_assigned_orders,
            'total_refunded_orders' => $refunded_orders,

            'total_earnings' => $total_order,
            'total_refunds' => $total_order,
            'total_order_revenue' => $total_order,
            'total_withdrawals' => $total_order,
            'total_tax' => $total_order,
            'total_subscription_earnings' => $total_order,
            'total_revenue' => $total_order,
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
