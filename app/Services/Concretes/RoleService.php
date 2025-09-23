<?php

namespace App\Services\Concretes;

use App\Models\Role;
use App\Services\Contracts\RoleServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class RoleService implements RoleServiceInterface
{
    public function getAllRoles(): Collection
    {
        return Role::with('permissions')->get();
    }

    public function getRoleById(int $id): ?Model
    {
        return Role::with('permissions')->find($id);
    }

    public function createRole(array $data): Model
    {
        // Hanya ambil kolom 'name' dan 'slug' untuk create
        $role = Role::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);

        // Sync permissions ke pivot table
        if (!empty($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }

        return $role;
    }

    public function updateRole(int $id, array $data): Model
    {
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);

        // Update pivot table
        if (isset($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }

        return $role;
    }

    public function deleteRole(int $id): bool
    {
        $role = Role::findOrFail($id);

        // Hapus semua relasi di pivot table
        $role->permissions()->detach();

        return $role->delete();
    }
}
