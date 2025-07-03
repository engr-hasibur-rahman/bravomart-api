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
use App\Models\OrderDetail;
use App\Models\OrderMaster;
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
use Modules\Subscription\app\Models\SubscriptionHistory;
use Modules\Wallet\app\Models\WalletWithdrawalsTransaction;

class AdminDashboardManageRepository implements AdminDashboardManageInterface
{
    public function __construct(protected User $user)
    {

    }

    /* <-------------------------------------------------------- User Analytics Start --------------------------------------------------------> */
    public function getSummaryData(?int $store_id = null)
    {
        $total_store = Store::count();
        $total_seller = User::where('store_owner', 1)->count();
        $total_product = Product::count();
        $total_customer = Customer::count();
        $total_staff = User::where('activity_scope', 'store_level')
            ->where('store_owner', '!=', 1)
            ->count();

        if ($store_id) {
            $total_order = Order::where('store_id', $store_id)->count();
            $pending_orders = Order::where('store_id', $store_id)->where('status', 'pending')->count();
            $confirmed_orders = Order::where('store_id', $store_id)->where('status', 'confirmed')->count();
            $processing_orders = Order::where('store_id', $store_id)->where('status', 'processing')->count();
            $shipped_orders = Order::where('store_id', $store_id)->where('status', 'shipped')->count();
            $completed_orders = Order::where('store_id', $store_id)->where('status', 'delivered')->count();
            $cancelled_orders = Order::where('store_id', $store_id)->where('status', 'cancelled')->count();
            $deliveryman_not_assigned_orders = Order::where('store_id', $store_id)->where('status', 'processing')->whereNull('confirmed_by')->count();
            $refunded_orders = Order::where('store_id', $store_id)->where('refund_status', 'refunded')->count();
        } else {
            $total_order = Order::count();
            $pending_orders = Order::where('status', 'pending')->count();
            $confirmed_orders = Order::where('status', 'confirmed')->count();
            $processing_orders = Order::where('status', 'processing')->count();
            $shipped_orders = Order::where('status', 'shipped')->count();
            $completed_orders = Order::where('status', 'delivered')->count();
            $cancelled_orders = Order::where('status', 'cancelled')->count();
            $deliveryman_not_assigned_orders = Order::where('status', 'processing')->whereNull('confirmed_by')->count();
            $refunded_orders = Order::where('refund_status', 'refunded')->count();
        }

        $total_areas = StoreArea::count();
        $total_deliverymen = User::where('activity_scope', 'delivery_level')->count();
        $total_categories = ProductCategory::count();
        $total_brands = ProductBrand::count();
        $total_sliders = Slider::count();
        $total_coupons = Coupon::count();
        $total_pages = Page::count();
        $total_blogs = Blog::count();
        $total_tickets = Ticket::count();
        $total_earnings = Order::whereHas('orderMaster', function ($q) {
            $q->where('payment_status', 'paid');
        })
            ->where(function ($q) {
                $q->where('refund_status', '!=', 'refunded')
                    ->orWhereNull('refund_status');
            })
            ->sum('order_amount');
        $total_refunds = Order::where('refund_status', 'refunded')->sum('order_amount');
        $total_withdrawals = WalletWithdrawalsTransaction::where('status', 'approved')->sum('amount');
        $total_subscription_earnings = SubscriptionHistory::where('status', 1)->where('payment_status', 'paid')->sum('price');
        $total_tax = OrderDetail::whereHas('order', function ($orderQuery) {
            $orderQuery->where(function ($q) {
                $q->where('refund_status', '!=', 'refunded')
                    ->orWhereNull('refund_status');
            })
                ->whereHas('orderMaster', function ($masterQuery) {
                    $masterQuery->where('payment_status', 'paid');
                });
        })->sum('total_tax_amount');
        $total_admin_commission_amount = Order::whereHas('orderMaster', function ($q) {
            $q->where('payment_status', 'paid');
        })
            ->where(function ($q) {
                $q->WhereNull('refund_status');
            })
            ->sum('order_amount_admin_commission');
        $total_order_revenue = $total_earnings - $total_refunds;
        $total_revenue = ($total_order_revenue + $total_admin_commission_amount + $total_subscription_earnings) - $total_tax;

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
            'total_confirmed_orders' => $confirmed_orders,
            'total_processing_orders' => $processing_orders,
            'total_shipped_orders' => $shipped_orders,
            'total_delivered_orders' => $completed_orders,
            'total_cancelled_orders' => $cancelled_orders,
            'deliveryman_not_assigned_orders' => $deliveryman_not_assigned_orders,
            'total_refunded_orders' => $refunded_orders,

            'total_earnings' => $total_earnings,
            'total_order_commission' => $total_admin_commission_amount,
            'total_refunds' => $total_refunds,
            'total_order_revenue' => $total_order_revenue,
            'total_withdrawals' => $total_withdrawals,
            'total_tax' => $total_tax,
            'total_subscription_earnings' => $total_subscription_earnings,
            'total_revenue' => $total_revenue,
        ];
    }
    public function getSummaryDataWithFilters(array $filters): array
    {
        $orderQuery = Order::query();

        if (!empty($filters['store_id'])) {
            $orderQuery->where('store_id', $filters['store_id']);
        }

        if (!empty($filters['order_status'])) {
            $orderQuery->where('status', $filters['order_status']);
        }

        if (!empty($filters['customer_id'])) {
            $orderQuery->whereHas('orderMaster', function ($q) use ($filters) {
                $q->where('customer_id', $filters['customer_id']);
            });
        }

        if (!empty($filters['payment_gateway'])) {
            $orderQuery->whereHas('orderMaster', function ($q) use ($filters) {
                $q->where('payment_gateway', $filters['payment_gateway']);
            });
        }

        if (!empty($filters['payment_status'])) {
            $orderQuery->whereHas('orderMaster', function ($q) use ($filters) {
                $q->where('payment_status', $filters['payment_status']);
            });
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $orderQuery->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        } elseif (!empty($filters['start_date'])) {
            $orderQuery->whereDate('created_at', '>=', $filters['start_date']);
        } elseif (!empty($filters['end_date'])) {
            $orderQuery->whereDate('created_at', '<=', $filters['end_date']);
        }

        if (!empty($filters['type'])) {
            $orderQuery->whereHas('store', function ($q) use ($filters) {
                $q->where('store_type', $filters['type']);
            });
        }

        if (!empty($filters['area_id'])) {
            $orderQuery->where('area_id', $filters['area_id']);
        }

        // Now calculate the rest same as before using the filtered query
        $total_order = $orderQuery->count();
        $pending_orders = (clone $orderQuery)->where('status', 'pending')->count();
        $confirmed_orders = (clone $orderQuery)->where('status', 'confirmed')->count();
        $processing_orders = (clone $orderQuery)->where('status', 'processing')->count();
        $shipped_orders = (clone $orderQuery)->where('status', 'shipped')->count();
        $completed_orders = (clone $orderQuery)->where('status', 'delivered')->count();
        $cancelled_orders = (clone $orderQuery)->where('status', 'cancelled')->count();
        $deliveryman_not_assigned_orders = (clone $orderQuery)->where('status', 'processing')->whereNull('confirmed_by')->count();
        $refunded_orders = (clone $orderQuery)->where('refund_status', 'refunded')->count();

        // earnings, revenue etc
        $total_earnings = (clone $orderQuery)
            ->whereHas('orderMaster', function ($q) {
                $q->where('payment_status', 'paid');
            })
            ->where(function ($q) {
                $q->where('refund_status', '!=', 'refunded')
                    ->orWhereNull('refund_status');
            })->sum('order_amount');

        $total_refunds = (clone $orderQuery)->where('refund_status', 'refunded')->sum('order_amount');

        $total_admin_commission_amount = (clone $orderQuery)
            ->whereHas('orderMaster', function ($q) {
                $q->where('payment_status', 'paid');
            })
            ->whereNull('refund_status')
            ->sum('order_amount_admin_commission');

        $total_order_revenue = $total_earnings - $total_refunds;

        $total_tax = OrderDetail::whereHas('order', function ($q) use ($filters) {
            if (!empty($filters['store_id'])) {
                $q->where('store_id', $filters['store_id']);
            }

            $q->where(function ($subQ) {
                $subQ->where('refund_status', '!=', 'refunded')->orWhereNull('refund_status');
            })->whereHas('orderMaster', function ($masterQ) {
                $masterQ->where('payment_status', 'paid');
            });
        })->sum('total_tax_amount');

        $total_subscription_earnings = SubscriptionHistory::where('status', 1)
            ->where('payment_status', 'paid')
            ->sum('price');

        $total_revenue = ($total_order_revenue + $total_admin_commission_amount + $total_subscription_earnings) - $total_tax;

        // static counts
        $total_store = Store::count();
        $total_seller = User::where('store_owner', 1)->count();
        $total_product = Product::count();
        $total_customer = Customer::count();
        $total_staff = User::where('activity_scope', 'store_level')->where('store_owner', '!=', 1)->count();
        $total_areas = StoreArea::count();
        $total_deliverymen = User::where('activity_scope', 'delivery_level')->count();
        $total_categories = ProductCategory::count();
        $total_brands = ProductBrand::count();
        $total_sliders = Slider::count();
        $total_coupons = Coupon::count();
        $total_pages = Page::count();
        $total_blogs = Blog::count();
        $total_tickets = Ticket::count();
        $total_withdrawals = WalletWithdrawalsTransaction::where('status', 'approved')->sum('amount');

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
            'total_confirmed_orders' => $confirmed_orders,
            'total_processing_orders' => $processing_orders,
            'total_shipped_orders' => $shipped_orders,
            'total_delivered_orders' => $completed_orders,
            'total_cancelled_orders' => $cancelled_orders,
            'deliveryman_not_assigned_orders' => $deliveryman_not_assigned_orders,
            'total_refunded_orders' => $refunded_orders,

            'total_earnings' => $total_earnings,
            'total_order_commission' => $total_admin_commission_amount,
            'total_refunds' => $total_refunds,
            'total_order_revenue' => $total_order_revenue,
            'total_withdrawals' => $total_withdrawals,
            'total_tax' => $total_tax,
            'total_subscription_earnings' => $total_subscription_earnings,
            'total_revenue' => $total_revenue,
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

    public function getOrderGrowthData()
    {
        $year = Carbon::now()->year;

        // Fetch order counts per month
        $monthlyData = Order::whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total_orders')
            )
            ->pluck('total_orders', 'month');
        // Fill missing months with 0
        return collect(range(1, 12))->mapWithKeys(fn($month) => [$month => $monthlyData->get($month, 0)]);
    }

    public function getOtherSummaryData()
    {
        $topRatedProducts = $this->getTopRatedProducts();

        $topSellingStores = $this->getTopSellingStores();

        $recentCompletedOrders = $this->getRecentCompletedOrders();

        $topCategories = $this->getTopCategories();

        return [
            'top_rated_products' => $topRatedProducts,
            'top_selling_stores' => $topSellingStores,
            'recent_completed_orders' => $recentCompletedOrders,
            'top_categories' => $topCategories,
        ];
    }

    public function getTopCategories()
    {
        $topCategoryIds = Product::select('category_id')
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->orderByRaw('SUM(order_count) DESC')
            ->limit(10)
            ->pluck('category_id');

        return ProductCategory::with('translations')
            ->whereIn('id', $topCategoryIds)
            ->get()
            ->sortBy(function ($category) use ($topCategoryIds) {
                return array_search($category->id, $topCategoryIds->toArray());
            })
            ->values(); // To reindex the collection properly
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
