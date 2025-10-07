<?php

namespace App\Http\Resources\Api\Enumeration;

use Illuminate\Http\Resources\Json\JsonResource;

class EnumerationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'name' => $this->name,
            'value' => $this->value,
            'group' => $this->group,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
