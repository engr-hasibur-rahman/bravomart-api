<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FlashDealProductRequest extends FormRequest
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
            'flash_sale_id' => 'required|exists:flash_sales,id',
            'products*' => 'required|exists:products,id',
            'store_id' => 'nullable|exists:com_merchant_stores,id',
        ];
    }

    public function messages()
    {
        return [
            'flash_sale_id.required' => __('validation.required', ['attribute' => 'Flash Sale']),
            'flash_sale_id.exists' => __('validation.exists', ['attribute' => 'Flash Sale']),
            'products*.required' => __('validation.required', ['attribute' => 'Products']),
            'products*.exists' => __('validation.exists', ['attribute' => 'Products']),
            'store_id.exists' => __('validation.exists', ['attribute' => 'Store']),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
