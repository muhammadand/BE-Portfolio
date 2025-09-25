<?php

namespace App\Http\Requests\Api\V1\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:product_categories,slug',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:product_categories,id',
        ];
    }
}

