<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemCommission extends Model
{
    protected $table = 'system_commissions';

    protected $fillable = [
        'subscription_enabled',                 // Enable or disable subscriptions
        'commission_enabled',                   // Enable or disable commission
        'commission_type',                      // 'percentage' or 'flat'
        'commission_amount',                    // Commission value
        'default_order_commission_rate',        // Default commission for orders
        'default_delivery_commission_charge',   // Default commission for deliveries
        'order_shipping_charge',                // Shipping charge for orders
        'order_confirmation_by',                // Manual or automatic confirmation
        'include_tax',                          // Include tax in order calculations
        'additional_charge_enabled',            // Enable or disable additional charge
        'additional_charge_name',               // Name of the additional charge
        'additional_charge_amount',             // Amount of the additional charge
    ];

    protected $casts = [
        'subscription_enabled' => 'boolean',
        'commission_enabled' => 'boolean',
        'include_tax' => 'boolean',
        'additional_charge_enabled' => 'boolean',
    ];

    public function calculateCommission(float $amount): float
    {
        if (!$this->commission_enabled) {
            return 0;
        }

        return $this->commission_type === 'percentage'
            ? ($this->commission_amount / 100) * $amount
            : $this->commission_amount;
    }

    public function calculateAdditionalCharge(float $amount): float
    {
        if (!$this->additional_charge_enabled) {
            return 0;
        }

        return $this->additional_charge_amount;
    }
}
