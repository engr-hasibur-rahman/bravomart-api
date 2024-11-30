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
        Schema::create('product_product_variant', function (Blueprint $table) {
            $table->id();
            $table->foreign('product_id')->references('id')->on('product_product')->onDelete('cascade');
            $table->string('variant_slug')->nullable();
            $table->string('sku')->nullable();
            $table->string('pack_quantity')->nullable();
            $table->string('weight_major')->unique();
            $table->string('weight_gross')->nullable();
            $table->string('weight_net')->nullable();
            $table->string('variant_image')->nullable(); //[{"sliding_image":"xyx.jpg","position":1},{"sliding_image":"abc.jpg","position":2}]
            $table->string('variant_order_count')->nullable();
            $table->string('status')->nullable(); //1. Active, 2. Inactive or empty
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_product_variant');
        Schema::dropIfExists('product_product');
    }
};
