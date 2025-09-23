<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface PermissionServiceInterface
{
    public function getAllPermissions(): Collection;
    public function getPermissionById(int $id): ?Model;
    public function createPermission(array $data): Model;
    public function updatePermission(int $id, array $data): Model;
    public function deletePermission(int $id): bool;
}
