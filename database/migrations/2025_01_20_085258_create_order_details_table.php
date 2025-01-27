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
            $table->unsignedBigInteger('order_package_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('behaviour')->nullable()->comment('service, digital, consumable, combo');
            $table->string('product_sku')->nullable();
            $table->json('variant_details')->nullable(); // product variants
            $table->unsignedBigInteger('product_campaign_id')->nullable();
            $table->string('store_discount_type')->nullable(); // percent/ fixed
            $table->decimal('store_discount_rate')->nullable(); // 2% or 100-USD
            $table->decimal('store_discount_amount')->nullable();  // 100
            $table->string('admin_discount_type')->nullable(); // percent/ fixed
            $table->decimal('admin_discount_rate')->nullable(); // 2% or 100-USD
            $table->decimal('admin_discount_amount')->nullable(); // 100
            $table->decimal('base_price')->nullable(); // product main price
            $table->decimal('price')->nullable();
            $table->decimal('quantity')->nullable();
            $table->decimal('tax_percent')->nullable();
            $table->decimal('tax_amount')->nullable();
            $table->decimal('line_total_price')->nullable();
            $table->timestamps();
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
