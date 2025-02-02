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
        Schema::create('order_remittances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->decimal('order_amount')->nullable(); // Amount under this delivery package
            $table->decimal('order_amount_store_value')->nullable(); // Amount under this delivery package
            $table->decimal('order_amount_admin_commission')->nullable(); // Amount under this delivery package
            $table->decimal('delivery_charge_admin')->nullable(); // If central Delivery then Value will be here
            $table->decimal('delivery_charge_store')->nullable(); // In future If store delivery enabled, then Charge will store here
            $table->decimal('delivery_charge_admin_commission')->nullable(); // If Store delivery then admin will receive commission
            $table->decimal('additional_charge')->nullable(); // For additional delivery charge if, inter-area or Per KM enabled etc
            $table->decimal('additional_charge_store_value')->nullable();
            $table->decimal('additional_charge_admin_commission')->nullable();
            $table->decimal('extra_packing_charge')->nullable();
            $table->decimal('extra_packing_charge_store_value')->nullable();
            $table->decimal('extra_packing_charge_admin_commission')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_remittances');
    }
};
