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
            $table->string('type')->nullable(); //medicine/ furniture/ DOOR/ FOOD/ GROCERY
            $table->string('behaviour')->nullable(); //1. product 2. consu 3. combo 4. service
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('brand_id')->nullable();
            $table->string('unit_name')->nullable();
            $table->string('class')->nullable(); //This will controll product attribute, different attribute for food/medicine/cloth
            $table->string('warranty')->nullable(); //[ { "warranty_period": 5,    "warranty_text": " Years for Compressor"  }, { "warranty_period": 2,    "warranty_text": " Years for Spare Parts"  }]
            $table->string('return_in_dsays')->nullable();
            $table->string('return_text')->nullable(); // Ex:  Days return Policy, Box Required
            $table->string('allow_change_in_mind')->nullable();
            $table->integer('cash_on_delivery')->nullable(); //0=Not available 100=Available 40=60% advance and rest amount is Cash on Delevery
            $table->string('delivery_time_min')->nullable();
            $table->string('delivery_time_max')->nullable();
            $table->string('delivery_time_text')->nullable(); //*Can be delay if natural disaster
            $table->string('tags')->nullable();
            $table->string('thumb_image')->nullable();
            $table->string('full_image')->nullable();
            $table->string('product_slug')->nullable();
            $table->string('status')->nullable(); //pending, approved, inactive, suspended
            $table->integer('max_cart_qty')->nullable();
            $table->integer('rating_count')->nullable();
            $table->decimal('rating_average')->nullable();
            $table->integer('order_count')->nullable();
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
