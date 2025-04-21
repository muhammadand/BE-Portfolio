<?php

namespace App\Repositories\User\Concretes;

use App\Models\User;
use App\Repositories\Base\Concretes\QueryableRepository;
use App\Repositories\User\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;

class UserRepository extends QueryableRepository implements UserRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    protected function model(): string
    {
        return User::class;
    }

    /**
     * Return All Users
     *
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->getFiltered();
    }

    /**
     * Get allowed filters for this repository.
     *
     * @return array
     */
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            'name',
            'email'
        ];
    }

    /**
     * Get allowed sorts for this repository.
     *
     * @return array
     */
    public function getAllowedSorts(): array
    {
        return ['id', 'name'];
    }

    /**
     * Get allowed includes for this repository.
     *
     * @return array
     */
    public function getAllowedIncludes(): array
    {
        // Add any relationships you want to allow including
        // For example: 'posts', 'comments', etc.
        return [];
    }

    /**
     * Get allowed fields for this repository.
     *
     * @return array
     */
    public function getAllowedFields(): array
    {
        // return ['id', 'name', 'email', 'created_at', 'updated_at'];
        return [];
    }
}
