<?php

namespace App\Repositories\Role\Concretes;

use App\Models\Role;
use App\Repositories\Base\Concretes\QueryableRepository;
use App\Repositories\Role\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;

class RoleRepository extends QueryableRepository implements RoleRepositoryInterface
{
    protected function model(): string
    {
        return Role::class;
    }

    public function getRoles(): Collection
    {
        return $this->getFiltered();
    }

    public function getActiveRoles(): Collection
    {
        return $this->model->where('is_active', 1)->get();
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
        return ['id', 'name'];
    }

    public function getAllowedIncludes(): array
    {
        return ['permissions'];
    }

    public function getAllowedFields(): array
    {
        return ['id', 'name', 'slug'];
    }
}
