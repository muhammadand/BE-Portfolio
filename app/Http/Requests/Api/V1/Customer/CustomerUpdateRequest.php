<?php

namespace App\Http\Requests\Api\V1\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => 'sometimes|required|string|max:255',
            'email'      => 'sometimes|nullable|email|max:255',
            'phone'      => 'sometimes|nullable|string|max:20',
            'channel_id' => 'sometimes|nullable|integer|exists:enumerations,id',
        ];
    }
}
