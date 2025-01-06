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
        Schema::create('withdraw_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Method name (e.g., "PayPal", "Bank Transfer")
            $table->longText('fields')->nullable()->comment('Configuration fields for the method, stored as JSON');
            $table->decimal('min_withdrawal', 10, 2)->nullable()->comment('Minimum amount allowed for withdrawal');
            $table->decimal('max_withdrawal', 10, 2)->nullable()->comment('Maximum amount allowed for withdrawal');
            $table->decimal('transaction_fee', 10, 2)->nullable()->comment('Fee for each transaction');
            $table->string('fee_type')->default('fixed')->comment('fixed or percentage');
            $table->integer('status')->default(1)->comment('1=active, 0=inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_gateways');
    }
};
