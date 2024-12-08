<?php

use App\Enums\StoreType;
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
        Schema::create('com_stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->enum('store_type', array_map(fn($enum) => $enum->value, StoreType::cases()))->nullable(); //medicine/ furniture/ DOOR/ FOOD/ GROCERY
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('phone', 15)->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('vat_tax_number')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->string('subscription_type', 50)->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->decimal('admin_commi_percent', 5, 2)->nullable(); // Commission percentage
            $table->decimal('admin_commi_amount', 10, 2)->nullable(); // Fixed commission amount
            $table->decimal('delivery_charge', 10, 2)->nullable();
            $table->string('delivery_time', 50)->nullable();
            $table->boolean('delivery_self_system')->default(false);
            $table->boolean('delivery_take_away')->default(false);
            $table->integer('order_minimum')->default(0);
            $table->integer('veg_status')->default(0)->comment('0 = Non-Vegetarian, 1 = Vegetarian');
            $table->string('off_day', 50)->nullable(); // e.g., 'Sunday'
            $table->integer('enable_saling')->default(0)->comment('0 = Sales disabled, 1 = Sales enabled');
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('status')->default(0)->comment('0 = Pending, 1 = Active, 2 = Inactive');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('com_stores');
    }
};
