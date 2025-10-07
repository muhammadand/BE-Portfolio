<?php

namespace App\Http\Requests\Api\V1\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // nanti bisa pakai policy
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:products,slug',
            'category_id' => 'required|exists:product_categories,id',
            'vendor_id'   => 'required|exists:vendors,id',
            'vendor_sku'  => 'required|string|max:100',
            'sku'         => 'nullable|string|max:100|unique:products,sku',
            'days'        => 'nullable|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ];
    }
}
