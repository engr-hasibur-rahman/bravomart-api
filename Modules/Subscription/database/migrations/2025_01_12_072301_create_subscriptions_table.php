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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Subscription package name
            $table->integer('validity'); // Validity period in days
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->double('price', 10, 2)->default(0); // Price of the subscription plan
            $table->boolean('pos_system')->default(false); // Access to POS system
            $table->boolean('self_delivery')->default(false); // Whether self-delivery is allowed
            $table->boolean('mobile_app')->default(false); // Access to a mobile app
            $table->boolean('live_chat')->default(false); // Access to chat support
            $table->integer('order_limit')->default(0); // Maximum order limit
            $table->integer('product_limit')->default(0); // Maximum item limit
            $table->integer('product_featured_limit')->default(0); // Number of featured listings included
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('status')->default(0)->comment('0=inactive, 1=active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
