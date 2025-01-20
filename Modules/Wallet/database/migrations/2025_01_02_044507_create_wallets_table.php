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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');  // Polymorphic ID (User ID or Customer ID)
            $table->string('owner_type');  // Polymorphic type (User or Customer)
            $table->double('balance')->default(0);
            $table->tinyInteger('status')->default(1)->comment('0=inactive, 1=active');
            $table->timestamps();
            // Index for polymorphic columns for performance
            $table->index(['owner_id', 'owner_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
