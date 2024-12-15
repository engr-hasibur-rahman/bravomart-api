<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CityRequest extends FormRequest
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
            'state_id' => 'required|exists:states,id',
            'status' => 'required|boolean|in:0,1', // 0=inactive, 1=active
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required', ['name' => 'City']),
            'name.string' => __('validation.string', ['name' => 'City']),
            'name.max' => __('validation.max.string', ['name' => 'City']),

            'state_id.required' => __('validation.required', ['state_id' => 'State']),
            'state_id.exists' => __('validation.exists', ['name' => 'State']),

            'status.required' => __('validation.required', ['name' => 'Status']),
            'status.boolean' => __('validation.boolean', ['name' => 'Status']),
            'status.in' => __('validation.in', ['name' => 'Status']),
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
