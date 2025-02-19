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
        Schema::create('store_finances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->decimal('earnings', 15, 2)->default(0);
            $table->decimal('withdrawn', 15, 2)->default(0);
            $table->decimal('refunds', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_finances');
    }
};
