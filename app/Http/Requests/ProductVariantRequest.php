<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProductVariantRequest extends FormRequest
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
        return [
            // Validate that 'product_id' is either null or exists in the 'products' table.
            'product_id' => 'required|exists:products,id',
            'variant_slug' => 'nullable|string|max:255|unique:product_variants,variant_slug,' . $this->id,
            // Similar validation as 'variant_slug' but for SKU (Seller's Stock Keeping Unit).
            'sku' => 'nullable|string|max:255|unique:product_variants,sku,' . $this->id,
            // Validate 'pack_quantity' as a nullable numeric value that cannot be negative.
            'pack_quantity' => 'nullable|numeric|min:0',
            // Validate 'weight_major' as a nullable numeric value that cannot be negative.
            'weight_major' => 'nullable|numeric|min:0',
            // Validate 'weight_gross' as a nullable numeric value that cannot be negative.
            'weight_gross' => 'nullable|numeric|min:0',
            // Validate 'weight_net' as a nullable numeric value that cannot be negative.
            'weight_net' => 'nullable|numeric|min:0',
            // Ensure 'color' is a nullable string with a maximum length of 255 characters.
            'color' => 'nullable|string|max:255',
            // Ensure 'size' is a nullable string with a maximum length of 255 characters.
            'size' => 'nullable|string|max:255',
            // Validate 'price' as a nullable numeric value that cannot be negative.
            'price' => 'nullable|numeric|min:0',

            // Validate 'special_price' as a nullable numeric value that:
            // - Cannot be negative.
            // - Must be less than or equal to 'price'.
            'special_price' => 'nullable|numeric|min:0|lte:price',

            // Ensure 'stock_quantity' is a required integer that cannot be negative.
            'stock_quantity' => 'required|integer|min:0',

            // Validate that 'unit_id' is either null.
            'unit_id' => 'nullable',
            // // Validate that 'unit_id' is either null or exists in the 'units' table.
            // 'unit_id' => 'nullable|exists:units,id',

            // Validate 'length' as a nullable numeric value that cannot be negative.
            'length' => 'nullable|numeric|min:0',

            // Validate 'width' as a nullable numeric value that cannot be negative.
            'width' => 'nullable|numeric|min:0',

            // Validate 'height' as a nullable numeric value that cannot be negative.
            'height' => 'nullable|numeric|min:0',

            // Ensure 'image' is a nullable string in valid JSON format.
            'image' => 'nullable',

            // Ensure 'order_count' is a nullable integer that cannot be negative.
            'order_count' => 'nullable|integer|min:0',

            // Ensure 'status' is required and must be either 0 (inactive) or 1 (active).
            'status' => 'required|integer|in:0,1',
        ];
    }
    public function messages()
    {
        return [
            // Custom messages for each validation rule to provide user-friendly feedback.
            'product_id.required' => 'The product is required. ',
            'product_id.exists' => 'The selected product does not exist.',
            'variant_slug.unique' => 'The variant slug must be unique.',
            'sku.unique' => 'The SKU must be unique.',
            'special_price.lte' => 'The special price must be less than or equal to the base price.',
            'stock_quantity.required' => 'Stock quantity is required.',
            'status.in' => 'The status must be either 0 (inactive) or 1 (active).',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
