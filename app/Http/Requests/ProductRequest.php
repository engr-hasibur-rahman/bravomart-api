<?php

namespace App\Http\Requests;

use App\Enums\Behaviour;
use App\Enums\StatusType;
use App\Enums\StoreType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {       


        $rules = [
            "shop_id" => "required",
            "category_id" => "required",
            "brand_id" => "required",
            "unit_id" => "required",
            "attribute_id" => "required",
            "tag_id" => "required",
            "type" => "required|in:" . implode(',', array_column(StoreType::cases(), 'value')),
            "name" => "required",
            "description" => "required",
            "image" => "nullable",
            "gallery_images" => "nullable",
            "warranty" => "nullable",
            "return_in_days" => "nullable",
            "cash_on_delivery" => "nullable",
            "behaviour" => "required|in:" . implode(',', array_column(Behaviour::cases(), 'value')),
            "delivery_time_min" => "nullable",
            "delivery_time_max" => "nullable",
            "delivery_time_text" => "nullable",
            "attributes" => "required",
            "status" => "required|in:" . implode(',', array_column(StatusType::cases(), 'value')),
        ];

        // Conditional validation for variants
        //     if ($this->has('variants') && is_array($this->input('variants')) && count($this->input('variants')) > 0) {
        //     $rules['variants'] = 'required|array';
        //     $rules['variants.*.variant_slug'] = 'nullable|string|max:255|unique:product_variants,variant_slug';
        //     $rules['variants.*.sku'] = 'nullable|string|max:255|unique:product_variants,sku';
        //     $rules['variants.*.pack_quantity'] = 'nullable|numeric|min:0';
        //     $rules['variants.*.price'] = 'nullable|numeric|min:0';
        //     $rules['variants.*.stock_quantity'] = 'required|integer|min:0';
        //     $rules['variants.*.special_price'] = 'nullable|numeric|min:0|lte:variants.*.price';
        //     $rules['variants.*.color'] = 'nullable|string|max:255';
        //     $rules['variants.*.size'] = 'nullable|string|max:255';
        // }

         // Conditional validation for variants
    if ($this->has('variants') && is_array($this->input('variants')) && count($this->input('variants')) > 0) {
        $rules['variants'] = 'required|array';
        $rules['variants.*.variant_slug'] = 'nullable|string|max:255|unique:product_variants,variant_slug,' . ($this->route('product') ?? 0) . ',id'; // Ignore the unique validation for the current record when updating
        $rules['variants.*.sku'] = 'nullable|string|max:255|unique:product_variants,sku,' . ($this->route('product') ?? 0) . ',id'; // Ignore the unique validation for the current record when updating
        $rules['variants.*.pack_quantity'] = 'nullable|numeric|min:0';
        $rules['variants.*.price'] = 'nullable|numeric|min:0';
        $rules['variants.*.stock_quantity'] = 'required|integer|min:0';
        $rules['variants.*.special_price'] = 'nullable|numeric|min:0|lte:variants.*.price'; // You might need custom logic for dynamic comparison
        $rules['variants.*.color'] = 'nullable|string|max:255';
        $rules['variants.*.size'] = 'nullable|string|max:255';
    }

        return $rules;

    }
    public function messages()
    {
        
        return [
            "shop_id.required" => "The shop ID is required.",
            "category_id.required" => "The category ID is required.",
            "brand_id.required" => "The brand ID is required.",
            "unit_id.required" => "The unit ID is required.",
            "attribute_id.required" => "The attribute ID is required.",
            "tag_id.required" => "The tag ID is required.",
            "type.required" => "The type is required.",
            "type.in" => "The selected type is invalid.",
            "name.required" => "The product name is required.",
            "description.required" => "The product description is required.",
            "behaviour.required" => "The behaviour is required.",
            "behaviour.in" => "The selected behaviour is invalid.",
            "attributes.required" => "Attributes are required.",
            "status.required" => "The status is required.",
            "status.in" => "The selected status is invalid.",
            "variants.required" => "Variants are required when included.",
            "variants.*.variant_slug.unique" => "Each variant slug must be unique.",
            "variants.*.sku.unique" => "Each SKU must be unique.",
            "variants.*.stock_quantity.required" => "Stock quantity is required for each variant.",
            "variants.*.special_price.lte" => "Special price must be less than or equal to the price.",
        ];
    }
    private function getEnumValues(string $enumClass): string
    {
        return implode(', ', array_map(fn($case) => $case->value, $enumClass::cases()));
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
