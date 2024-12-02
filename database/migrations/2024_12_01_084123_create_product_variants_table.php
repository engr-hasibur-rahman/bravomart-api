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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('variant_slug')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('pack_quantity')->nullable();
            $table->decimal('weight_major')->nullable();
            $table->decimal('weight_gross')->nullable();
            $table->decimal('weight_net')->nullable();
            $table->string('variant_image')->nullable(); //[{"sliding_image":"xyx.jpg","position":1},{"sliding_image":"abc.jpg","position":2}]
            $table->integer('variant_order_count')->nullable();
            $table->string('status')->nullable(); //1. Active, 2. Inactive or empty
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
