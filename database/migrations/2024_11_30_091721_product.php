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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('attribute_id')->nullable();
            $table->string('type')->nullable();
            $table->string('behaviour')->nullable();
            $table->string('name')->unique();
            $table->longText('description')->nullable();
            $table->string('warranty')->nullable();
            //$table->enum('type', ['medicine', 'furniture', 'food', 'grocery', 'service'])->nullable();
            $table->string('return_in_dsays')->nullable();
            $table->string('return_text')->nullable();
            $table->string('allow_change_in_mind')->nullable();
            $table->integer('cash_on_delivery')->nullable();
            $table->string('delivery_time_min')->nullable();
            $table->string('delivery_time_max')->nullable();
            $table->string('delivery_time_text')->nullable();
            $table->string('tags')->nullable();
            $table->string('thumb_image')->nullable();
            $table->string('full_image')->nullable();
            $table->string('slug')->nullable();
            $table->integer('max_cart_qty')->nullable();
            $table->integer('order_count')->nullable();
            $table->string('attributes')->nullable();
            $table->integer('views')->default(0);
            $table->enum('status', ['draft','pending', 'approved', 'inactive', 'suspended'])->default('draft');
            $table->timestamp('available_time_starts')->nullable();
            $table->timestamp('available_time_ends')->nullable();
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
