<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class NoticeRequest extends FormRequest
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
            'message' => 'nullable|string',
            'type' => 'nullable|enum|in:general,specific_store,specific_vendor',
            'priority' => 'nullable|enum|in:low,medium,high',
            'active_date' => 'nullable|date|date_format:Y-m-d',
            'expire_date' => 'nullable|date|date_format:Y-m-d|after_or_equal:active_date',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('validation.required', ['attribute' => 'Title']),
            'title.string' => __('validation.string', ['attribute' => 'Title']),
            'title.max' => __('validation.max.string', ['attribute' => 'Title']),
            'message.string' => __('validation.string', ['attribute' => 'Message']),
            'type.enum' => __('validation.enum', ['general', 'specific_store', 'specific_vendor']),
            'priority.enum' => __('validation.enum', ['low', 'medium', 'high']),
            'active_date.date' => __('validation.date', ['attribute' => 'Active Date']),
            'active_date.date_format' => __('validation.date', ['attribute' => 'Active Date', 'format' => 'Y-m-d']),
            'expire_date.date' => __('validation.date', ['attribute' => 'Expire Date']),
            'expire_date.date_format' => __('validation.date', ['attribute' => 'Expire Date', 'format' => 'Y-m-d']),
            'expire_date.after' => __('validation.date', ['attribute' => 'Expire Date']),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
