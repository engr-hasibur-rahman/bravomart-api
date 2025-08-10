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
use Illuminate\Database\Eloquent\Relations\Relation;
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
        // change
        User::observe(UserObserver::class);
        Customer::observe(CustomerObserver::class);
        Store::observe(SellerStoreWiseObserver::class);
        Store::observe(StoreObserver::class);
        Order::observe(OrderObserver::class);

        // relationship add
        Relation::morphMap([
            'customer'     => Customer::class,
            'admin'        => User::class,
            'deliveryman'  => User::class,
            'store'        => Store::class,
        ]);

        $timezone = com_option_get('com_site_time_zone') ?? 'UTC';

        config(['app.timezone' => $timezone]);
        date_default_timezone_set($timezone);
    }
}
