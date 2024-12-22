<?php

namespace App\Http\Requests;

use App\Models\ComMerchantStore;
use App\Rules\ValidSellerStore;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class SellerStaffStoreRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users,email', // Ensures email is unique
            'password'   => 'required|string|min:8|max:12', // Enforces password length
            'phone'      => 'nullable|string|max:15', // Optional phone field
            'stores' => 'nullable|array',
            'stores.*'    => ['nullable', 'integer', new ValidSellerStore],  // Use the custom validation rule here
            'roles' => 'nullable|array',
            'roles.*.value' => 'required|string|exists:roles,name', // Assuming roles are validated against a 'roles' table
        ];
    }


    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'The first name is required.',
            'last_name.required' => 'The last name is required.',
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password must not exceed 12 characters.',
            'stores.*.exists' => 'One or more selected stores are invalid.',
            'roles.*.value.required' => 'Each role must have a value.',
            'roles.*.value.exists' => 'The role provided does not exist.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
