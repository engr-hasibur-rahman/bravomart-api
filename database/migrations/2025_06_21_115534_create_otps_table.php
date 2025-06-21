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
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->comment('Phone number');
            $table->string('otp');
            $table->enum('type', ['login', 'register', 'reset', '2fa']);
            $table->enum('channel', ['sms', 'email', 'whatsapp', 'push'])->default('sms');
            $table->timestamp('expires_at');
            $table->integer('attempts')->default(0);
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
