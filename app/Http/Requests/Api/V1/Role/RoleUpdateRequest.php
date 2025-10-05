<?php


namespace App\Http\Requests\Api\V1\Role;

use Illuminate\Foundation\Http\FormRequest;



class RoleUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $roleId = $this->route('role');

        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $roleId,
            // 'slug' => 'required|string|max:255|unique:roles,slug,' . $roleId,
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ];
    }
}
