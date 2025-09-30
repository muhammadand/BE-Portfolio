<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface RoleServiceInterface
{
    public function getRoles(): Collection;

    public function getAllRoles(): Collection;

    public function getFilteredRoles(?Request $request = null, int $perPage = 15): LengthAwarePaginator;

    public function getRoleById(int $id): ?Model;

    public function createRole(array $data): Model;

    public function updateRole(int $id, array $data): Model;

    public function deleteRole(int $id): bool;

    public function getActiveRoles(): Collection;
}
