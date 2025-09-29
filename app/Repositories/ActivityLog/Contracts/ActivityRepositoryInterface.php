<?php

namespace App\Repositories\ActivityLog\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ActivityRepositoryInterface
{
    /**
     * Ambil semua activity log dengan filter, sort, include
     *
     * @return Collection
     */
    public function getActivities(array $filters = []): Collection;
}
