<?php

namespace App\Http\Requests\Api\V1\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // nanti bisa pakai policy
    }

    public function rules(): array
    {
        $productId = $this->route('product'); // ambil dari route parameter

        return [
            'name'        => 'sometimes|string|max:255',
            'slug'        => "sometimes|string|max:255|unique:products,slug,{$productId}",
            'category_id' => 'sometimes|exists:product_categories,id',
            'vendor_id'   => 'sometimes|exists:vendors,id',
            'vendor_sku'  => 'sometimes|string|max:100',
            'sku'         => "sometimes|string|max:100|unique:products,sku,{$productId}",
            'days'        => 'sometimes|integer|min:0',
            'price'       => 'sometimes|numeric|min:0',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ];
    }
}
