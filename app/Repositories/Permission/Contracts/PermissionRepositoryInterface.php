<?php

namespace App\Repositories\Permission\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Base\Contracts\QueryableRepositoryInterface;

interface PermissionRepositoryInterface extends QueryableRepositoryInterface
{
    /**
     * Return all permissions with filters, sorts, includes, etc.
     */
    public function getPermissions(): Collection;
}
