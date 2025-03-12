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
            'title_color' => 'nullable|string|max:255', // Added title_color
            'description' => 'nullable|string',
            'description_color' => 'nullable|string|max:255', // Added description_color
            'button_text' => 'nullable|string|max:255', // Added button_text
            'button_text_color' => 'nullable|string|max:255', // Added button_text_color
            'button_hover_color' => 'nullable|string|max:255', // Added button_hover_color
            'button_bg_color' => 'nullable|string|max:255', // Added button_bg_color
            'button_url' => 'nullable|url|max:255', // Added button_url
            'timer_bg_color' => 'nullable|string|max:255', // Added timer_bg_color
            'timer_text_color' => 'nullable|string|max:255', // Added timer_text_color
            'image' => 'nullable|image|max:255', // Added image validation (optional, max size)
            'cover_image' => 'nullable|image|max:255', // Added cover_image validation (optional, max size)
            'discount_type' => 'nullable|in:percentage,amount',
            'discount_amount' => 'nullable|numeric',
            'special_price' => 'nullable|numeric',
            'purchase_limit' => 'nullable|integer',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'nullable|in:0,1',
            'product_ids' => 'nullable|array|exists:products,id', // Assuming `product_ids` needs to be validated as array
        ];
    }

    /**
     * Get custom error messages for validation.
     */
    public function messages()
    {
        return [
            'title.required' => __('validation.required', ['attribute' => 'Title']),
            'title.string' => __('validation.string', ['attribute' => 'Title']),
            'title.max' => __('validation.max.string', ['attribute' => 'Title', 'max' => 255]),
            'description.string' => __('validation.string', ['attribute' => 'Description']),
            'description_color.string' => __('validation.string', ['attribute' => 'Description Color']),
            'discount_type.in' => __('validation.in', ['attribute' => 'Discount Type', 'enum' => 'percentage or amount']),
            'discount_amount.numeric' => __('validation.numeric', ['attribute' => 'Discount Amount']),
            'special_price.numeric' => __('validation.numeric', ['attribute' => 'Special Price']),
            'purchase_limit.integer' => __('validation.integer', ['attribute' => 'Purchase Limit']),
            'start_time.required' => __('validation.required', ['attribute' => 'Start Time']),
            'start_time.date' => __('validation.date', ['attribute' => 'Start Time']),
            'end_time.required' => __('validation.required', ['attribute' => 'End Time']),
            'end_time.date' => __('validation.date', ['attribute' => 'End Time']),
            'end_time.after' => __('validation.after', ['attribute' => 'End Time']),
            'product_ids.array' => __('validation.array', ['attribute' => 'Product IDs']),
            'product_ids.exists' => __('validation.exists', ['attribute' => 'Product IDs']),
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
