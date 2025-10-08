<?php

namespace App\Http\Requests\Api\V1\Permission;

use Illuminate\Foundation\Http\FormRequest;

class PermissionStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'group' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:permissions,slug',
        ];
    }
}
