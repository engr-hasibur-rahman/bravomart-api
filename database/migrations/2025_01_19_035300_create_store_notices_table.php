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
        Schema::create('store_notices', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable()->comment('all_seller, specific_seller');
            $table->json('seller_id')->nullable(); // specific_seller ids
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('priority')->nullable()->comment('high, medium, low');
            $table->date('active_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_notices');
    }
};
