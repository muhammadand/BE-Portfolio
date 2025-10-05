<?php

namespace App\Repositories\ActivityLog\Contracts;

use App\Repositories\Base\Contracts\QueryableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface ActivityRepositoryInterface extends QueryableRepositoryInterface
{
    /**
     * Ambil semua activity log dengan filter, sort, include
     *
     * @return Collection
     */
    public function getActivities(): Collection;
}
