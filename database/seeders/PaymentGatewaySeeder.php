<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\PaymentGateways\app\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentGateway::create([
            'name' => 'paypal',
            'slug' => 'paypal', // Add a slug value
            'description' => 'fdf',
            'auth_credentials' => json_encode([
                'paypal_sandbox_client_id' => 'your-paypal-client-id',
                'paypal_sandbox_client_secret' => 'your-paypal-client-secret',
                'paypal_sandbox_client_app_id' => 'sandbox', // or "live"
            ]),
            'image' => '100',
            'status' => true,
            'is_test_mode' => true,
        ]);
    }
}
