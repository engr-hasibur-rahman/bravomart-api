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
        $seller = Store::where('id', $data['store_id'])->pluck('store_seller_id')->first();
        return ProductQuery::create([
            'product_id' => $data['product_id'],
            'customer_id' => $customer->id,
            'question' => $data['question'],
            'seller_id' => $seller,
        ]);
    }

    public function searchQuestion(array $data)
    {
        return ProductQuery::query()
            ->where('product_id', $data['product_id'])
            ->where('status', 1)
            ->where('customer_id', '!=', auth('api_customer')->user()->id) // Exclude the logged-in customer's questions
            ->where(function ($query) use ($data) {
                $query->where('question', 'LIKE', '%' . $data['search'] . '%')
                    ->orWhere('reply', 'LIKE', '%' . $data['search'] . '%');
            })
            ->latest()
            ->paginate(10);
    }
}
