<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            
            // Validasi untuk array roles
            'roles' => ['required', 'array'], // harus ada dan berupa array
            'roles.*' => ['integer', 'exists:roles,id'], // tiap element harus ID role yang valid
        ];
    }

    /**
     * Optional: custom messages
     */
    public function messages(): array
    {
        return [
            'roles.required' => 'Field roles harus diisi.',
            'roles.array' => 'Field roles harus berupa array.',
            'roles.*.exists' => 'Role yang dipilih tidak valid.',
        ];
    }
}
