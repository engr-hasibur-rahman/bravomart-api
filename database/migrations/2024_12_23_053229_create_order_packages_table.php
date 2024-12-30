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
        Schema::create('order_packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->string('shipping_type')->nullable();
            // Keeping Duplicate Column in Order & Store table. Due to our complex order structure, Here we will kep Store wise Summary To Show in his cart. Main Order Table will store Summarized data
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
            $table->boolean('is_reviewed')->nullable();


            $table->timestamps();
        });
        Schema::table('order_packages', function($table) {
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('com_merchant_stores')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_stores');
    }
};
