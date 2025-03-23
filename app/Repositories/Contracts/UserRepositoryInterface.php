<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find users by role
     *
     * @param string $role
     * @return Collection
     */
    public function findByRole(string $role): Collection;
}
