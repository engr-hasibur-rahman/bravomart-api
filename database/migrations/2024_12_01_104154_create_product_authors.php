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
        Schema::create('product_authors', function (Blueprint $table) {
            $table->id();
            $table->string('profile_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('bio')->nullable();
            $table->dateTime('born_date')->nullable();
            $table->dateTime('death_date')->nullable();
            $table->string('status')->nullable(); //1. Active or empty, 2. Inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_authors');
    }
};

