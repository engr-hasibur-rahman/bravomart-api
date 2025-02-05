<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'store_area_id' => 'required|exists:store_areas,id',
            'store_type_id' => 'required|exists:store_types,id',
            'min_km' => 'required|numeric|min:0',
            'max_km' => 'required|numeric|gt:min_km',
            'charge_amount' => 'required|numeric|min:0',
            'status' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'store_area_id.required' => __('validation.required',['attribute'=>'Store Area ID']),
        ];
    }
}
