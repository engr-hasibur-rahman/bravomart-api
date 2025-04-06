<?php

namespace App\Http\Requests;

use App\Models\Store;
use App\Rules\ValidSellerStore;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class SellerStaffStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->id),
            ],
            'password' => 'nullable|string|min:8|max:12',
            'phone' => 'nullable|string|max:15',
            'image' => 'nullable',
            'stores' => 'nullable|array',
            'stores.*' => ['nullable', 'integer', new ValidSellerStore],
            'roles' => 'nullable|array',
            'roles.*.value' => 'required|string|exists:roles,name',
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
