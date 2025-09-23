<?php

namespace App\Http\Resources\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->roles->map(function($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'slug' => $role->slug,
                    'permissions' => $role->permissions->map(function($perm) {
                        return [
                            'id' => $perm->id,
                            'name' => $perm->name,
                            'slug' => $perm->slug,
                        ];
                    }),
                ];
            }),
            'all_permissions' => $this->all_permissions->map(function($perm) {
                return [
                    'id' => $perm->id,
                    'name' => $perm->name,
                    'slug' => $perm->slug,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
