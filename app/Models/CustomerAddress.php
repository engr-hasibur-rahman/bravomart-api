<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = [
        'title',
        'customer_id',
        'type',
        'full_name',
        'phone_number',
        'email',
        'address_line_1',
        'address_line_2',
        'state',
        'city',
        'postal_code',
        'country',
        'is_default',
        'status',
    ];
    public function customer():void{
        $this->belongsTo('App\Models\Customer');
    }
}
