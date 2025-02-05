<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddAreaChargeRequest extends FormRequest
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
            'charges' => 'required|array|min:1',
            'charges.*.store_area_id' => 'required|exists:store_areas,id',
            'charges.*.store_type_id' => 'required|exists:store_types,id',
            'charges.*.min_km' => 'required|numeric|min:0',
            'charges.*.max_km' => 'required|numeric|gt:charges.*.min_km',
            'charges.*.charge_amount' => 'required|numeric|min:0',
            'charges.*.status' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return collect([
            'charges' => __('validation.required', ['attribute' => 'Charges']),
            'charges.array' => __('validation.array', ['attribute' => 'Charges']),
        ])->merge(
            collect([
                'store_area_id', 'store_type_id', 'min_km', 'max_km', 'charge_amount', 'status'
            ])->flatMap(function ($field) {
                return [
                    "charges.*.$field.required" => __('validation.required', ['attribute' => ucfirst(str_replace('_', ' ', $field))]),
                    "charges.*.$field.numeric" => __('validation.numeric', ['attribute' => ucfirst(str_replace('_', ' ', $field))]),
                    "charges.*.$field.min" => __('validation.min', ['attribute' => ucfirst(str_replace('_', ' ', $field))]),
                    "charges.*.$field.exists" => __('validation.exists', ['attribute' => ucfirst(str_replace('_', ' ', $field))]),
                    "charges.*.$field.boolean" => __('validation.boolean', ['attribute' => ucfirst(str_replace('_', ' ', $field))]),
                ];
            })
        )->toArray();
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
