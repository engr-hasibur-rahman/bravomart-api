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
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('area_id');
            $table->string('shipping_type');
            $table->string('shipping_address');
            $table->string('shipping_time_preferred');
            $table->string('delivery_status');
            $table->string('payment_type');
            $table->string('payment_status');

            $table->timestamps();
        });

        Schema::table('orders', function($table) {
            $table->foreign('store_id')->references('id')->on('com_merchant_stores')->onDelete('cascade');;
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
