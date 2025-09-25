<?php

namespace App\Http\Requests\Api\V1\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;
class ProductCategoryUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $id = $this->route('product_category'); // ambil id dari route
        return [
            'name' => 'required|string|max:255',
            'slug' => "required|string|unique:product_categories,slug,{$id}",
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:product_categories,id',
        ];
    }
}
