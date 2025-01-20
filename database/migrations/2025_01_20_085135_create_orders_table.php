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
            $table->string('shipping_time_preferred')->nullable();
            $table->string('delivery_status')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('order_notes')->nullable();

            $table->decimal('order_amount')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('coupon_title')->nullable();
            $table->decimal('coupon_disc_amt_admin')->nullable();
            $table->decimal('coupon_disc_amt_store')->nullable();

            $table->decimal('product_disc_amt')->nullable();
            $table->decimal('flash_disc_amt_admin')->nullable();
            $table->decimal('flash_disc_amt_store')->nullable();
            $table->decimal('shipping_charge')->nullable();
            $table->decimal('additional_charge')->nullable();


            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancel_request_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            //$table->string('delivery_status')->nullable();
            $table->timestamp('delivery_completed_at')->nullable();

            $table->string('refund_status')->nullable();

            $table->timestamps();
        });

        Schema::table('orders', function($table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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
