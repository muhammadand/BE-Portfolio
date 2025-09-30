<?php

namespace App\Repositories\Permission\Concretes;

use App\Models\Permission;
use App\Repositories\Base\Concretes\QueryableRepository;
use App\Repositories\Permission\Contracts\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;

class PermissionRepository extends QueryableRepository implements PermissionRepositoryInterface
{
    protected function model(): string
    {
        return Permission::class;
    }

    public function getPermissions(): Collection
    {
        return $this->getFiltered();
    }

    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            'name',
            'slug',
        ];
    }

    public function getAllowedSorts(): array
    {
        return ['id', 'name', 'slug'];
    }

    public function getAllowedIncludes(): array
    {
        return ['roles']; // asumsi relasi Permission ke Role ada
    }

    public function getAllowedFields(): array
    {
        return ['id', 'name', 'slug'];
    }
}
