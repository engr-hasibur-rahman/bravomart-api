<?php

namespace App\Http\Requests\Order;

use App\Rules\ValidateProductVariant;
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
            'payment_gateway' => 'required|string|in:paypal,stripe,cod,razorpay,paytm,wallet',
            'payment_status' => 'nullable|string|in:pending,completed,cancelled',
            'order_notes' => 'nullable|string|max:500',
            'order_amount' => 'required|numeric|min:0',
            'coupon_code' => 'nullable|string|max:50',
            'coupon_title' => 'nullable|string|max:255',
            'coupon_disc_amt_admin' => 'nullable|numeric|min:0',
            'product_disc_amt' => 'nullable|numeric|min:0',
            'flash_disc_amt_admin' => 'nullable|numeric|min:0',
            'flash_disc_amt_store' => 'nullable|numeric|min:0',
            'shipping_charge' => 'nullable|numeric|min:0',
            'additional_charge_title' => 'nullable|string',
            'additional_charge_amt' => 'nullable|numeric|min:0',
            // packages
            'packages' => 'required|array',
            'packages.*.store_id' => 'required|exists:com_merchant_stores,id',
            'packages.*.area_id' => 'required|exists:com_areas,id',
            'packages.*.order_type' => 'required',
            'packages.*.delivery_type' => 'required',
            'packages.*.shipping_type' => 'required',
            'packages.*.coupon_disc_amt_admin' => 'nullable|numeric',
            'packages.*.product_disc_amt' => 'nullable|numeric',
            'packages.*.flash_disc_amt_admin' => 'nullable|numeric',
            'packages.*.flash_disc_amt_store' => 'nullable|numeric',
            'packages.*.shipping_charge' => 'nullable|numeric',
            'packages.*.additional_charge' => 'nullable|numeric',
            'packages.*.order_amount' => 'required|numeric|min:0',
            // items
            'packages.*.items' => 'required|array',
            'packages.*.items.*.product_id' => 'required|exists:products,id',
            'packages.*.items.*.product_campaign_id' => 'nullable|numeric',
            'packages.*.items.*.variant_details.variant_id' => 'required|exists:product_variants,id',
            // discount store
            'packages.*.items.*.store_discount_type' => 'nullable',
            'packages.*.items.*.store_discount_rate' => 'nullable|numeric',
            'packages.*.items.*.store_discount_amount' => 'nullable|numeric',
            // discount store
            'packages.*.items.*.admin_discount_type' => 'nullable',
            'packages.*.items.*.admin_discount_rate' => 'nullable|numeric',
            'packages.*.items.*.admin_discount_amount' => 'nullable|numeric',
            // tax
            'packages.*.items.*.tax_percent' => 'nullable',
            'packages.*.items.*.tax_amount' => 'nullable|numeric',
            // qty and price
            'packages.*.items.*.quantity' => 'required|integer|min:1',
            'packages.*.items.*.line_total_price' => 'nullable|numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // the error response
        $errors = $validator->errors()->getMessages();
        // the response structure
        $response = [
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $errors
        ];
        throw new HttpResponseException(response()->json($response, 422));
    }
}
