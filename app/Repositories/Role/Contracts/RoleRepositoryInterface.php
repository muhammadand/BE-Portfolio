<?php

namespace App\Repositories\Role\Contracts;

use App\Repositories\Base\Contracts\QueryableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface extends QueryableRepositoryInterface
{
    public function getRoles(): Collection;

    public function getActiveRoles(): Collection;
}
