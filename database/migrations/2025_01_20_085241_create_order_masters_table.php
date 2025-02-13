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
        Schema::create('order_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->string('shipping_address_id')->nullable();
            $table->decimal('order_amount')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('coupon_title')->nullable();
            $table->decimal('coupon_discount_amount_admin')->nullable(); // admin set coupon discount amount
            $table->decimal('product_discount_amount')->nullable();
            $table->decimal('flash_discount_amount_admin')->nullable(); // admin set product for offer sell dis.
            $table->decimal('shipping_charge')->nullable(); // total order wise shipping charge
            $table->string('additional_charge_name')->nullable();
            $table->decimal('additional_charge_amount')->nullable();
            $table->decimal('additional_charge_commission')->nullable();
            $table->decimal('paid_amount')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->string('payment_status')->nullable()->comment('pending , paid, failed');
            $table->string('transaction_ref')->nullable();
            $table->string('transaction_details')->nullable();
            $table->string('order_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_masters');
    }
};
