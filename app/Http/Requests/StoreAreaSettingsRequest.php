<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAreaSettingsRequest extends FormRequest
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
            'store_type_ids' => 'required|array',
            'store_type_ids.*' => 'exists:store_types,id',
            'store_area_id' => 'required|exists:store_areas,id',
            'delivery_time_per_km' => 'required|integer|min:0',
            'min_order_delivery_fee' => 'nullable|numeric|min:0',
            'delivery_charge_method' => 'nullable|string|in:fixed,per_km,range_wise',
            'fixed_charge_amount' => 'nullable|numeric|min:0',
            'per_km_charge_amount' => 'nullable|numeric|min:0',
            'out_of_area_delivery_charge' => 'nullable|numeric|min:0',

            // Charges Array Validation
            'charges' => 'required|array|min:1',
            'charges.*.store_area_setting_id' => 'required|exists:store_area_settings,id',
            'charges.*.min_km' => 'required|numeric|min:0',
            'charges.*.max_km' => ['required', 'numeric', 'gt:min_km'], // Fixed the gt rule
            'charges.*.charge_amount' => 'required|numeric|min:0',
            'charges.*.status' => 'nullable|boolean', // Ensures it's a valid boolean value
        ];
    }

    public function messages()
    {
        return [
            'store_area_setting_id.required' => __('validation.required', ['attribute' => 'Store Area ID']),
            'store_area_setting_id.exists' => __('validation.exists', ['attribute' => 'Store Area ID']),

            'delivery_time_per_km.required' => __('validation.required', ['attribute' => 'Delivery Time Per KM']),
            'delivery_time_per_km.integer' => __('validation.integer', ['attribute' => 'Delivery Time Per KM']),
            'delivery_time_per_km.min' => __('validation.min', ['attribute' => 'Delivery Time Per KM']),

            'min_order_delivery_fee.numeric' => __('validation.numeric', ['attribute' => 'Minimum Order Delivery Fee']),
            'min_order_delivery_fee.min' => __('validation.min', ['attribute' => 'Minimum Order Delivery Fee']),

            'delivery_charge_method.string' => __('validation.string', ['attribute' => 'Delivery Charge Method']),
            'delivery_charge_method.in' => __('validation.in', ['attribute' => 'Delivery Charge Method', 'enum' => 'fixed,per_km,range_wise']),

            'fixed_charge_amount.numeric' => __('validation.numeric', ['attribute' => 'Fixed Amount']),
            'fixed_charge_amount.min' => __('validation.min', ['attribute' => 'Fixed Amount']),

            'per_km.numeric' => __('validation.numeric', ['attribute' => 'Per KM']),
            'per_km.min' => __('validation.min', ['attribute' => 'Per KM']),

            'out_of_area_delivery_charge.numeric'=>__('validation.numeric', ['attribute' => 'Out Of Area Delivery Charge']),
            'out_of_area_delivery_charge.min' => __('validation.min', ['attribute' => 'Out Of Area Delivery Charge']),

            'charges.required' => __('validation.required', ['attribute' => 'charges']),
            'charges.array' => __('validation.array', ['attribute' => 'charges']),
            'charges.min' => __('validation.min.numeric', ['attribute' => 'charges', 'min' => 1]),

            'charges.*.store_area_id.required' => __('validation.required', ['attribute' => 'Store Area ID']),
            'charges.*.store_area_id.exists' => __('validation.exists', ['attribute' => 'Store Area ID']),

            'charges.*.store_type_id.required' => __('validation.required', ['attribute' => 'Store Type ID']),
            'charges.*.store_type_id.exists' => __('validation.exists', ['attribute' => 'Store Type ID']),

            'charges.*.min_km.required' => __('validation.required', ['attribute' => 'Minimum KM']),
            'charges.*.min_km.numeric' => __('validation.numeric', ['attribute' => 'Minimum KM']),
            'charges.*.min_km.min' => __('validation.min.numeric', ['attribute' => 'Minimum KM', 'min' => 0]),

            'charges.*.max_km.required' => __('validation.required', ['attribute' => 'Maximum KM']),
            'charges.*.max_km.numeric' => __('validation.numeric', ['attribute' => 'Maximum KM']),
            'charges.*.max_km.gt' => __('validation.gt', ['attribute' => 'Maximum KM', 'value' => 'Minimum KM']),

            'charges.*.charge_amount.required' => __('validation.required', ['attribute' => 'Charge Amount']),
            'charges.*.charge_amount.numeric' => __('validation.numeric', ['attribute' => 'Charge Amount']),
            'charges.*.charge_amount.min' => __('validation.min.numeric', ['attribute' => 'Charge Amount', 'min' => 0]),

            'charges.*.status.boolean' => __('validation.boolean', ['attribute' => 'Status']),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
