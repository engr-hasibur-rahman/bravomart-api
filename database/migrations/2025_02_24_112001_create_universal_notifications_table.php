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
        Schema::create('universal_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message')->nullable();
            $table->enum('notifiable_type', ['admin', 'store', 'customer', 'deliveryman'])->default('customer');
            $table->unsignedBigInteger('notifiable_id');
            $table->json('data')->nullable();
            $table->enum('status', ['unread', 'read'])->default('unread');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universal_notifications');
    }
};
