<?php

namespace App\Repositories;

use App\Interfaces\ProductQueryManageInterface;
use App\Models\ProductQuery;
use App\Models\Store;

class ProductQueryManageRepository implements ProductQueryManageInterface
{
    public function askQuestion(array $data)
    {
        $customer = auth('api_customer')->user();
        $seller = Store::where('id', $data['store_id'])->pluck('seller_id')->first();
        $askQuestion = ProductQuery::create([
            'product_id' => $data['product_id'],
            'customer_id' => $customer->id,
            'question' => $data['question'],
            'seller_id' => $seller,
        ]);
    }
}
