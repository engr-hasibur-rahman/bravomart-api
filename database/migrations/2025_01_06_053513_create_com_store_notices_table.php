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
        Schema::create('com_store_notices', function (Blueprint $table) {
            $table->id();              
            $table->string('type')->default('general')->comment('general, specific_store, specific_seller');            
            $table->string('title'); 
            $table->longText('message')->nullable();
            $table->dateTime('active_date')->nullable()->comment('Start date of the notice'); // Active start date
            $table->dateTime('expire_date')->nullable()->comment('End date of the notice'); // Expiration date
            $table->string('priority', 10)->default('low')->comment('Priority: low, medium, high'); // Priority as a string
            $table->integer('status')->default(0)->comment('0=inactive, 1=active');
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('com_store_notices');
    }
};
