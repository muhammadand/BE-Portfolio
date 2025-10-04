<?php

namespace App\Services\Concretes;

use App\Repositories\Role\Contracts\RoleRepositoryInterface;
use App\Services\Base\Concretes\BaseService;
use App\Services\Contracts\RoleServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleService extends BaseService implements RoleServiceInterface
{
    public function __construct(protected RoleRepositoryInterface $roleRepository)
    {
        $this->setRepository($roleRepository);
    }

    public function getRoles(): Collection
    {
        return $this->repository->getFiltered();
    }

    public function getAllRoles(): Collection
    {
        return $this->repository->all();
    }

    public function getFilteredRoles(?Request $request = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginateFiltered($perPage);
    }

    public function getRoleById(int $id): ?Model
    {
        try {
            return $this->repository->findOrFail($id);
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('Role not found');
        }
    }

    public function createRole(array $data): Model
    {
        $role = $this->repository->create([
            'name' => $data['name'],
            // 'slug' => $data['slug'], // ❌ jangan diisi manual
        ]);
    
        if (!empty($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }
    
        return $role;
    }
    
    public function updateRole(int $id, array $data): Model
    {
        try {
            $role = $this->repository->update($id, [
                'name' => $data['name'],
                // 'slug' => $data['slug'], // ❌ hilangkan ini juga
            ]);
    
            if (isset($data['permissions'])) {
                $role->permissions()->sync($data['permissions']);
            }
    
            return $role;
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('Role not found');
        }
    }
    

    public function deleteRole(int $id): bool
    {
        try {
            $role = $this->repository->findOrFail($id);
            $role->permissions()->detach();
            $this->repository->delete($id);

            return true;
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('Role not found');
        }
    }

    public function getActiveRoles(): Collection
    {
        return $this->roleRepository->getActiveRoles();
    }
}
