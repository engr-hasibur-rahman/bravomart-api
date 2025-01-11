<?php

namespace App\Imports;

use App\Enums\Behaviour;
use App\Enums\StatusType;
use App\Enums\StoreType;
use App\Models\ComMerchantStore;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\ValidationException;

class ProductImport implements ToCollection, WithHeadingRow, WithValidation, WithChunkReading
{
    public function chunkSize(): int
    {
        // Number of rows to process at a time
        return 1000;
    }

    public function collection(\Illuminate\Support\Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $shopId = $row['store_id'];
            $productId = $row['id'];
            // Check if the shop belongs to the authenticated user
            $shopExists = ComMerchantStore::where('id', $shopId)
                ->where('merchant_id', auth('api')->id())
                ->exists();

            if (!$shopExists) {
                $errors = ["This file contains shop that does not belong to the authenticated user"];

                $validator = Validator::make([], []);
                $validator->errors()->add('shop_validation', $errors[0]);

                throw new ValidationException($validator);
            }

            // Check if the product already exists in the database
            $productExists = Product::where('store_id', $shopId)
                ->where('id', $productId)
                ->exists();

            if ($productExists) {
                // Skip this row if it already exists
                continue;
            }
            // Save or update product to the database
            Product::create(
                [
                    "store_id" => $row['store_id'],
                    "category_id" => $row['category_id'],
                    "brand_id" => $row['brand_id'] ?? null,
                    "unit_id" => $row['unit_id'] ?? null,
                    "tag_id" => $row['tag_id'] ?? null,
                    "name" => $row['name'],
                    "slug" => $row['slug'] ?? 'no-slug',
                    "warranty" => $row['warranty'],
                    "return_in_days" => $row['return_in_days'],
                    "type" => $row['type'],
                    "cash_on_delivery" => $row['cash_on_delivery'],
                    "behaviour" => $row['behaviour'],
                    "delivery_time_min" => $row['delivery_time_min'],
                    "delivery_time_max" => $row['delivery_time_max'],
                    "max_cart_qty" => $row['max_cart_qty'],
                    "order_count" => $row['order_count'] ?? 0,
                    "views" => $row['views'] ?? 0,
                    "status" => $row['status'],
                    "available_time_starts" => $row['available_time_starts'],
                    "available_time_ends" => $row['available_time_ends'],
                ]
            );
        }
    }

    /**
     * Define validation rules for imported rows
     */
    public function rules(): array
    {
        return [
            "store_id" => 'required|exists:com_merchant_stores,id',
            "category_id" => "required",
            "brand_id" => "required",
            "unit_id" => "required",
            "tag_id" => "required",
            "type" => "required|in:" . implode(',', array_column(StoreType::cases(), 'value')),
            "name" => "required",
            "behaviour" => "required|in:" . implode(',', array_column(Behaviour::cases(), 'value')),
            "status" => "required|in:" . implode(',', array_column(StatusType::cases(), 'value')),
        ];
    }

    /**
     * Define custom error messages
     */
    public function customValidationMessages(): array
    {
        return [
            "store_id.required" => "The shop ID is required.",
            "category_id.required" => "The category ID is required.",
            "brand_id.required" => "The brand ID is required.",
            "unit_id.required" => "The unit ID is required.",
            "tag_id.required" => "The tag ID is required.",
            "type.required" => "The type is required.",
            "behaviour.required" => "The behaviour is required.",
            "status.required" => "The status is required.",
        ];
    }
}
