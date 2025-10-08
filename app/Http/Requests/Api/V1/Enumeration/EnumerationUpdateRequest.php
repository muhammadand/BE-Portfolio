<?php

namespace App\Http\Requests\Api\V1\Enumeration;

use Illuminate\Foundation\Http\FormRequest;

class EnumerationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // nanti bisa disesuaikan dengan policy
    }

    public function rules(): array
    {
        return [
            'label' => 'sometimes|required|string|max:255',
            'name'  => 'sometimes|required|string|max:255',
            'value' => 'sometimes|required|string|max:255',
            'group' => 'nullable|string|max:255',
        ];
    }
}
