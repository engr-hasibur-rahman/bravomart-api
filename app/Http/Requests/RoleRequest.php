<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'role_name' => 'required|string|max:255',
            'permissions' => 'array',
            'available_for' => 'nullable|string|max:255',
            'permissions.*' => 'nullable',
        ];
    }
}
