<?php

namespace App\Http\Requests\Api\V1\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('product_category'); // ambil ID dari route parameter

        return [
            'parent_id'   => 'nullable|exists:product_categories,id',
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:product_categories,slug,' . $id,
            'description' => 'nullable|string',
        ];
    }
}
