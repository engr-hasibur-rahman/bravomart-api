<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\PaymentGateways\app\Models\PaymentGateway;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SettingSeeder::class);

        //$this->call(PermissionSeeder::class);
        $this->call(PermissionAdminSeeder::class);
        $this->call(PermissionStoreSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PaymentGatewaySeeder::class);
        $this->call(ProductAttributeSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(SubscriptionPackageSeeder::class);
        $this->call(DepartmentSeeder::class);
    }
}
