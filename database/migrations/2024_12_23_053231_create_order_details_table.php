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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_sku')->nullable();
            $table->string('product_details')->nullable();
            $table->string('variant_details')->nullable();
            $table->string('add_ons')->nullable();

            $table->decimal('rate_bef_discount')->nullable();
            $table->unsignedBigInteger('product_campaign_id')->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('discount_store_percent')->nullable();
            $table->decimal('discount_admin_percent')->nullable();
            $table->decimal('discount_store_amount')->nullable();
            $table->decimal('discount_admin_amount')->nullable();
            $table->decimal('rate')->nullable();
            $table->decimal('quantity')->nullable();
            $table->decimal('total_add_on_value')->nullable();
            $table->decimal('tax_percent')->nullable();
            $table->decimal('tax_amount')->nullable();
            $table->decimal('line_total')->nullable();

            $table->timestamps();
        });

        Schema::table('order_details', function($table) {
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
        Schema::dropIfExists('order_details');
    }
};
