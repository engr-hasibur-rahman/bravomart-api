<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'timezone' => 'nullable|string|max:255',
            'status' => 'required|boolean|in:0,1', // 0=inactive, 1=active
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required', ['attribute' => 'State name']),
            'name.string' => __('validation.string', ['attribute' => 'State name']),
            'name.max' => __('validation.max.string', ['attribute' => 'State name']),

            'country_id.required' => __('validation.required', ['attribute' => 'Country']),
            'country_id.exists' => (__('validation.exists', ['attribute' => 'Country'])),

            'timezone.string' => __('validation.string', ['attribute' => 'Timezone']),
            'timezone.max' => __('validation.max.string', ['attribute' => 'Timezone']),

            'status.required' => __('validation.required', ['attribute' => 'Status']),
            'status.boolean' => __('validation.boolean', ['attribute' => 'Status']),
            'status.in' => __('validation.in', ['attribute' => 'Status']),
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
