<?php

namespace App\Http\Resources\Api\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'category_id' => $this->category_id,
            'vendor_id'   => $this->vendor_id,
            'vendor_sku'  => $this->vendor_sku,
            'sku'  => $this->sku,
            'days'  => $this->days,
            'price'       => $this->price,
            'description' => $this->description,
            'is_active'   => $this->is_active,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
