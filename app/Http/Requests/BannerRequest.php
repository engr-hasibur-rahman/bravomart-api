<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class BannerRequest extends FormRequest
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
            'store_id' => 'required|exists:com_stores,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'background_image' => 'required|string',
            'redirect_url' => 'nullable|url|max:255',
            'status' => 'required|integer|in:0,1',
            'priority' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'store_id.required' => __('validation.required', ['attribute' => 'Store']),
            'store_id.exists' => __('validation.exists', ['attribute' => 'Store']),

            'title.required' => __('validation.required', ['attribute' => 'Title']),
            'title.string' => __('validation.string', ['attribute' => 'Title']),
            'title.max' => __('validation.max', ['attribute' => 'Title']),

            'description.string' => __('validation.string', ['attribute' => 'Description']),

            'background_image.required' => __('validation.required', ['attribute' => 'Background Image']),
            'background_image.string' => __('validation.string', ['attribute' => 'Background Image']),

            'redirect_url.url' => __('validation.url', ['attribute' => 'Redirect Url']),
            'redirect_url.max' => __('validation.max', ['attribute' => 'Redirect Url']),

            'status.required' => __('validation.required', ['attribute' => 'Status']),
            'status.integer' => __('validation.integer', ['attribute' => 'Status']),
            'status.in' => __('validation.in', ['attribute' => 'Status']),

            'priority.required' => __('validation.required', ['attribute' => 'Priority']),
            'priority.integer' => __('validation.integer', ['attribute' => 'Priority']),
            'priority.min' => __('validation.min', ['attribute' => 'Priority']),
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
