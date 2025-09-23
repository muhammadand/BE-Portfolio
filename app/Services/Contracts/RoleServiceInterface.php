<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RoleServiceInterface
{
    public function getAllRoles(): Collection;

    public function getRoleById(int $id): ?Model;

    public function createRole(array $data): Model;

    public function updateRole(int $id, array $data): Model;

    public function deleteRole(int $id): bool;
}
