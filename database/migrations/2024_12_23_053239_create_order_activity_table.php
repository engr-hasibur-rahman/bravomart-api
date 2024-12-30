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
        Schema::create('order_activity', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->string('activity_from')->nullable(); //Admin/Store/Customer
            $table->string('activity_type')->nullable(); // Cancel Reason/Customer Feedback/Review against Order to Seller
            $table->unsignedBigInteger('ref_id')->nullable(); // Reference ID from List Table
            $table->string('activity_title')->nullable(); // Text from Reference Table or Fixed text
            $table->string('activity_value')->nullable(); // Value of Given Activity, For Cancel reason there will be no Value, for feedback there may decimal value

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_activity');
    }
};
