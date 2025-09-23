<?php

namespace App\Http\Resources\Api\Permission;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'roles' => $this->roles->pluck('name'), // optional
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
