<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flash_sales', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('discount_type')->nullable()->comment('percentage or amount');
            $table->decimal('discount_price', 10, 2)->nullable()->comment('discounted price');
            $table->decimal('special_price', 10, 2)->nullable()->comment('special price for product');
            $table->unsignedInteger('purchase_limit')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->boolean('is_active')->default(1)->comment('1: active, 0: inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_sales');
    }
};
