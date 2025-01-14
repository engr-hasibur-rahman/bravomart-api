<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_commissions', function (Blueprint $table) {
            $table->id();
            $table->boolean('subscription_enabled')->default(false);
            $table->boolean('commission_enabled')->default(false);
            $table->string('commission_type')->nullable(); // percentage or flat
            $table->decimal('commission_amount', 8, 2)->default(0);
            $table->decimal('default_order_commission_rate', 8, 2)->nullable();
            $table->decimal('default_delivery_commission_charge', 8, 2)->nullable();
            $table->decimal('order_shipping_charge', 8, 2)->nullable();
            $table->string('order_confirmation_by')->nullable(); // 'manual' or 'automatic'
            $table->boolean('include_tax')->default(false);
            $table->boolean('additional_charge_enabled')->default(false);
            $table->string('additional_charge_name')->nullable();
            $table->decimal('additional_charge_amount', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_commissions');
    }
};
