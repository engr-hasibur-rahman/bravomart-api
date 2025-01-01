<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CouponLineRequest extends FormRequest
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
            'code' => 'required|string|max:255|unique:coupons,code,' . $this->id,
            'discount_type' => 'required|string|in:percentage,amount',
            'discount' => 'required|numeric|min:0',
            'product_id' => 'nullable|exists:products,id',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|after_or_equal:start_date|date_format:Y-m-d',
            'usage_limit' => 'nullable|integer|min:0',
            'usage_count' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'status' => 'required|integer|in:0,1',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'code.required' => 'The code field is required.',
            'code.unique' => 'The code must be unique.',
            'discount_type.required' => 'The discount type field is required.',
            'discount_type.in' => 'The discount type must be either percentage or amount.',
            'discount.required' => 'The discount field is required.',
            'discount.numeric' => 'The discount must be a number.',
            'product_id.exists' => 'The selected product does not exist.',
            'start_date.required' => 'The start date field is required.',
            "start_date.date_format" => "Incorrect date format!",
            'end_date.required' => 'The end date field is required.',
            "end_date.date_format" => "Incorrect date format!",
            'end_date.after_or_equal' => 'The end date must be a date after or equal to the start date.',
            'usage_limit.integer' => 'The usage limit must be an integer.',
            'usage_count.integer' => 'The usage count must be an integer.',
            'description.string' => 'The description must be a string.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either active (1) or inactive (0).',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
