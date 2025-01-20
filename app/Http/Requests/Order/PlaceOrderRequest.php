<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlaceOrderRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'shipping_address_id' => 'required|exists:customer_addresses,id',
            'shipping_time_preferred' => 'nullable|string|max:255',
            'payment_type' => 'required|string|in:credit_card,paypal,bank_transfer', // Example of payment types
            'payment_status' => 'nullable|string|in:pending,completed,cancelled',
            'order_notes' => 'nullable|string|max:500',
            'order_amount' => 'required|numeric|min:0',
            'coupon_code' => 'nullable|string|max:50',
            'coupon_title' => 'nullable|string|max:255',
            'coupon_disc_amt_admin' => 'nullable|numeric|min:0',
            'coupon_disc_amt_store' => 'nullable|numeric|min:0',
            'product_disc_amt' => 'nullable|numeric|min:0',
            'flash_disc_amt_admin' => 'nullable|numeric|min:0',
            'flash_disc_amt_store' => 'nullable|numeric|min:0',
            'shipping_charge' => 'nullable|numeric|min:0',
            'additional_charge' => 'nullable|numeric|min:0',
            'packages' => 'required|array',
            'packages.*.store_id' => 'required|exists:com_merchant_stores,id',
            'packages.*.order_amount' => 'required|numeric|min:0',
            'packages.*.items' => 'required|array',
            'packages.*.items.*.product_id' => 'required|exists:products,id',
            'packages.*.items.*.rate' => 'required|numeric|min:0',
            'packages.*.items.*.quantity' => 'required|integer|min:1',
            'packages.*.items.*.line_total' => 'required|numeric|min:0',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
