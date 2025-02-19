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
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_type')->nullable()->comment('store or deliveryman');
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->decimal('earnings', 15, 2)->default(0);
            $table->decimal('withdrawn', 15, 2)->default(0);
            $table->decimal('refunds', 15, 2)->default(0);
            $table->index(['user_id', 'user_type', 'current_balance']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balances');
    }
};
