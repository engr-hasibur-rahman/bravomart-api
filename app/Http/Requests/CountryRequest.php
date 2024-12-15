<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CountryRequest extends FormRequest
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
            'code' => 'required|string|size:2',
            'dial_code' => 'nullable|string|max:5',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'timezone' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'languages' => 'nullable|string|max:255',
            'status' => 'required|boolean|in:0,1', // 0=inactive, 1=active
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required', ['attribute' => 'Country']),
            'name.string' => __('validation.string', ['attribute' => 'Country']),
            'name.max' => __('validation.max.string', ['attribute' => 'Country']),

            'code.required' => __('validation.required', ['attribute' => 'Country code']),
            'code.string' => __('validation.string', ['attribute' => 'Country code']),
            'code.size' => __('validation.size', ['attribute' => 'Country code']),

            'dial_code.string' => __('validation.string', ['attribute' => 'Dial Code']),
            'dial_code.max' => __('validation.max.string', ['attribute' => 'Dial Code']),

            'latitude.string' => __('validation.string', ['attribute' => 'Latitude']),
            'latitude.max' => __('validation.max.string', ['attribute' => 'Latitude']),

            'longitude.string' => __('validation.string', ['attribute' => 'Longitude']),
            'longitude.max' => __('validation.max.string', ['attribute' => 'Longitude']),

            'timezone.string' => __('validation.string', ['attribute' => 'Timezone']),
            'timezone.max' => __('validation.max.string', ['attribute' => 'Timezone']),

            'region.string' => __('validation.string', ['attribute' => 'Region']),
            'region.max' => __('validation.max.string', ['attribute' => 'Region']),

            'languages.string' => __('validation.string', ['attribute' => 'Languages']),
            'languages.max' => __('validation.max.string', ['attribute' => 'Languages']),

            'status.required' => __('validation.required', ['attribute' => 'Status']),
            'status.boolean' => __('validation.boolean', ['attribute' => 'Status']),
            'status.in' => __('validation.in', ['attribute' => 'Status']),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
