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
        Schema::create('product_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->string('product_type')->nullable(); //medicine/ furniture/ DOOR/ FOOD/ GROCERY
            $table->string('product_behaviour')->nullable(); //1. product 2. consu 3. combo 4. service
            $table->string('product_name')->unique();
            $table->string('product_description')->nullable();
            $table->string('category_id')->nullable();
            $table->string('product_brand_id')->nullable();
            $table->string('product_uom_id')->nullable();
            $table->string('product_uom_name')->nullable();
            $table->string('product_class')->nullable(); //This will controll product attribute, different attribute for food/medicine/cloth
            $table->string('product_warranty')->nullable(); //[ { "warranty_period": 5,    "warranty_text": " Years for Compressor"  }, { "warranty_period": 2,    "warranty_text": " Years for Spare Parts"  }]
            $table->string('return_in_dsays')->nullable();
            $table->string('return_text')->nullable(); // Ex:  Days return Policy, Box Required
            $table->string('allow_change_in_mind')->nullable();
            $table->string('cash_on_delivery')->nullable(); //0=Not available 100=Available 40=60% advance and rest amount is Cash on Delevery
            $table->string('delivery_time_min')->nullable();
            $table->string('delivery_time_max')->nullable();
            $table->string('delivery_time_text')->nullable(); //*Can be delay if natural disaster
            $table->string('product_tags')->nullable();
            $table->string('product_thumb')->nullable();
            $table->string('product_image')->nullable();
            $table->string('product_slug')->nullable();
            $table->string('status')->nullable(); //pending, approved, inactive, suspended
            $table->string('maximum_cart_qty')->nullable();
            $table->string('rating_count')->nullable();
            $table->string('rating_average')->nullable();
            $table->string('order_count')->nullable();
            $table->string('attributes')->nullable();
            $table->timestamp('available_time_starts')->nullable(); //Only for Food Item
            $table->timestamp('available_time_ends')->nullable(); //Only for Food Item
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Will Remove while Child Table variant removed
    }
};
