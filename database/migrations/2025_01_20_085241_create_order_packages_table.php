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
            // Order Type (Defines the nature of the order: regular, POS, etc.)
            $table->string('order_type')->nullable()->comment('regular, pos');
            // Delivery Type (Defines how the customer will receive the order: home delivery, pickup, etc.)
            $table->string('delivery_type')->nullable()->comment('delivery, parcel, takeaway');
            // Shipping Type (Defines how the goods are shipped: courier service, standard shipping, etc.)
            $table->string('shipping_type')->nullable()->comment('standard, express, freight');
            $table->decimal('order_amount')->nullable();
            $table->decimal('coupon_disc_amt_admin')->nullable(); // store wise discount amount
            $table->decimal('product_disc_amt')->nullable();  // store wise product discount amount
            $table->decimal('flash_disc_amt_admin')->nullable(); // store wise dis.. discount amount
            $table->decimal('flash_disc_amt_store')->nullable(); // store wise dis.. discount amount
            $table->decimal('shipping_charge')->nullable(); // separate store wise shipping charge amount but total shipping amount in main order table
            $table->decimal('additional_charge')->nullable();  // separate store wise add.. shipping charge amount but total add.. shipping amount in main order table
            $table->boolean('is_reviewed')->nullable(); // customer review for order wise product reviews check
            $table->string('status')->default('pending')->comment('pending, active, processing , shipped, delivered, cancelled, on_hold');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_packages');
    }
};
