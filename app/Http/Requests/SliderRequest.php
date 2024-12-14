<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SliderRequest extends FormRequest
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
            'sub_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url',
            'redirect_url' => 'nullable|url',
            'order' => 'nullable|integer|min:1|unique:sliders,order,' . $this->id,
            'status' => 'integer|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => __('validation.required'),
            'title.string' => __('validation.string'),
            'title.max' => __('validation.max.string'),

            'sub_title.string' => __('validation.string'),
            'sub_title.max' => __('validation.max.string'),

            'description.string' => __('validation.string'),

            'button_text.string' => __('validation.string'),
            'button_text.max' => __('validation.max.string'),

            'button_url.url' => __('validation.url'),

            'redirect_url.url' => __('validation.url'),

            'order.integer' => __('validation.integer'),
            'order.min' => __('validation.integer'),
            'order.unique' => __('validation.unique'),

            'status.integer' => __('validation.integer'),
            'status.in' => __('validation.in'),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
