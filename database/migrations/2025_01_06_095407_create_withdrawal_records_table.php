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
        Schema::create('withdrawal_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('user_type')->nullable()->comment('store or deliveryman')->index();
            $table->unsignedBigInteger('withdraw_gateway_id')->index();
            $table->double('amount');
            $table->double('fee')->default(0.00); // Fee applied to the withdrawal
            $table->json('gateways_options')->nullable();
            $table->string('status')->default('pending')->comment('pending, approved, rejected');
            $table->longText('details')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable()->index(); // Approved by reference
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_records');
    }
};
