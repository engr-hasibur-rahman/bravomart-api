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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('shipping_address_id')->nullable();
            $table->string('payment_gateway')->nullable(); // cod, paypal, stripe, paytm, re-pay
            $table->string('payment_status')->nullable(); // pending , paid, failed
            $table->string('order_notes')->nullable();
            $table->decimal('order_amount')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('coupon_title')->nullable();
            $table->decimal('coupon_disc_amt_admin')->nullable(); // admin set coupon discount amount
            $table->decimal('product_disc_amt')->nullable();
            $table->decimal('flash_disc_amt_admin')->nullable(); // admin set product for offer sell dis.
            $table->decimal('flash_disc_amt_store')->nullable(); // seller  set product for offer sell dis.
            $table->decimal('shipping_charge')->nullable(); // admin set shipping charge set
            $table->decimal('additional_charge_title')->nullable();
            $table->decimal('additional_charge_amt')->nullable();
            $table->unsignedBigInteger('confirmed_by')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->unsignedBigInteger('cancel_request_by')->nullable();
            $table->timestamp('cancel_request_at')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('delivery_completed_at')->nullable();
            $table->string('refund_status')->nullable(); // requested, processing, refunded
            $table->string('status')->default('pending')->comment('pending, active, processing , shipped, delivered, cancelled, on_hold');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
