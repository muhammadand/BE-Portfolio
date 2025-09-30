<?php

namespace App\Services\Concretes;

use App\Models\Permission;
use App\Repositories\Permission\Contracts\PermissionRepositoryInterface;
use App\Services\Contracts\PermissionServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PermissionService implements PermissionServiceInterface
{
    public function __construct(
        protected readonly PermissionRepositoryInterface $permissionRepository
    ) {}

    /**
     * Mengambil semua permission (mentah, tanpa filter).
     */
    public function getAllPermissions(): Collection
    {
        return Permission::all();
    }

    /**
     * Mengambil permissions dengan filter/sort/include
     */
    public function getPermissions(): Collection
    {
        return $this->permissionRepository->getPermissions();
    }

    public function getPermissionById(int $id): ?Model
    {
        return Permission::find($id);
    }

    public function createPermission(array $data): Model
    {
        return Permission::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);
    }

    public function updatePermission(int $id, array $data): Model
    {
        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);

        return $permission;
    }

    public function deletePermission(int $id): bool
    {
        $permission = Permission::findOrFail($id);

        // Lepas semua relasi dengan role
        $permission->roles()->detach();

        return $permission->delete();
    }
}
