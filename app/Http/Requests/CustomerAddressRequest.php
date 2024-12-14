<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerAddressRequest extends FormRequest
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
//            'customer_id' => 'required|exists:users,id',
            'title' => 'nullable|string|max:255',
            'type' => 'required|string',
            'full_name' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_default' => 'required|boolean',
            'status' => 'required|integer|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
//            'customer_id.required' => __('validation.required', ['attribute' => 'Customer']),
//            'customer_id.exists' => __('validation.exists', ['attribute' => 'Customer']),
            'title.string' => __('validation.required'),
            'title.max' => __('validation.max.string'),
            'type.required' => __('validation.required'),
            'full_name.max' => __('validation.max.string'),
            'phone_number.required' => __('validation.required'),
            'phone_number.max' => __('validation.max.string'),
            'email.email' => __('validation.email'),
            'email.max' => __('validation.max.string'),
            'address_line_1.required' => __('validation.required'),
            'address_line_1.string' => __('validation.string'),
            'address_line_1.max' => __('validation.max.string'),
            'address_line_2.string' => __('validation.string'),
            'address_line_2.max' => __('validation.max.string'),
            'city.required' => __('validation.required'),
            'city.string' => __('validation.string'),
            'city.max' => __('validation.max.string'),
            'state.string' => __('validation.string'),
            'state.max' => __('validation.max.string'),
            'postal_code.required' => __('validation.required'),
            'postal_code.string' => __('validation.string'),
            'postal_code.max' => __('validation.max.string'),
            'country.required' => __('validation.required'),
            'country.string' => __('validation.string'),
            'country.max' => __('validation.max.string'),
            'is_default.required' => __('validation.required', ['attribute' => 'Is Default']),
            'is_default.boolean' => __('validation.boolean', ['attribute' => 'Is Default']),
            'status.required' => __('validation.required'),
            'status.integer' => __('validation.integer'),
            'status.in' => __('validation.in'),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
