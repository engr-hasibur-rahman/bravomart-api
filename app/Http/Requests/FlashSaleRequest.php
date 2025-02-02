<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FlashSaleRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'nullable|in:percentage,amount',
            'cover_image' => 'nullable|max:255',
            'thumbnail_image' => 'nullable|max:255',
            'discount_amount' => 'nullable|numeric',
            'special_price' => 'nullable|numeric',
            'purchase_limit' => 'nullable|integer',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('validation.required', ['attribute' => 'Title']),
            'title.string' => __('validation.string', ['attribute' => 'Title']),
            'title.max' => __('validation.max.string', ['attribute' => 'Title', 'max' => 255]),
            'description.string' => __('validation.string', ['attribute' => 'Description']),
            'discount_type.in' => __('validation.in', ['attribute' => 'Discount Type', 'enum' => 'percentage or amount']),
            'discount_amount.numeric' => __('validation.numeric', ['attribute' => 'Discount Amount']),
            'special_price.numeric' => __('validation.numeric', ['attribute' => 'Special Price']),
            'purchase_limit.integer' => __('validation.integer', ['attribute' => 'Purchase Limit']),
            'start_time.required' => __('validation.required', ['attribute' => 'Start Time']),
            'start_time.date' => __('validation.date', ['attribute' => 'Start Time']),
            'end_time.required' => __('validation.required', ['attribute' => 'End Time']),
            'end_time.date' => __('validation.date', ['attribute' => 'End Time']),
            'end_time.after' => __('validation.after', ['attribute' => 'End Time']),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
