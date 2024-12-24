<?php

namespace Modules\PaymentGateways\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\PaymentGateways\Database\Factories\PaymentGatewayFactory;

class PaymentGateway extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): PaymentGatewayFactory
    // {
    //     // return PaymentGatewayFactory::new();
    // }
}
