<?php

namespace App\Repositories;

use App\Interfaces\AdminDashboardManageInterface;
use App\Models\Store;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AdminDashboardManageRepository implements AdminDashboardManageInterface
{
    public function __construct(protected User $user)
    {

    }

    /* <-------------------------------------------------------- User Analytics Start --------------------------------------------------------> */
    public function getSummaryData()
    {
       $storeCount = Store::count();
       $storeOwnerCount = User::where('store_owner', 1)->count();
       $productCount = Product::count();
       $orderCount = 0;
       return [
           'storeCount' => $storeCount,
           'storeOwnerCount' => $storeOwnerCount,
           'productCount' => $productCount,
           'orderCount' => $orderCount
       ];
    }
    /* <-------------------------------------------------------- User Analytics End --------------------------------------------------------> */
}
