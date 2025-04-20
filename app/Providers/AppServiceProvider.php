<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Store;
use App\Models\Customer;
use App\Models\User;
use App\Observers\OrderObserver;
use App\Observers\SellerStoreWiseObserver;
use App\Observers\CustomerObserver;
use App\Observers\StoreObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Customer::observe(CustomerObserver::class);
        Store::observe(SellerStoreWiseObserver::class);
        Store::observe(StoreObserver::class);
        Order::observe(OrderObserver::class);
    }
}
