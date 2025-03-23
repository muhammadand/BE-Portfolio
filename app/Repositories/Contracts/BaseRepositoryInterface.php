<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    /**
     * Get all resources
     *
     * @param array $columns
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection;
    
    /**
     * Get paginated resources
     *
     * @param int $perPage
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;
    
    /**
     * Find resource by id
     *
     * @param int $id
     * @param array $columns
     * @return Model|null
     */
    public function find(int $id, array $columns = ['*']): ?Model;
    
    /**
     * Find resource by field
     *
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return Model|null
     */
    public function findByField(string $field, mixed $value, array $columns = ['*']): ?Model;
    
    /**
     * Find resource or fail
     *
     * @param int $id
     * @param array $columns
     * @return Model
     */
    public function findOrFail(int $id, array $columns = ['*']): Model;
    
    /**
     * Create new resource
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;
    
    /**
     * Update resource
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model;
    
    /**
     * Delete resource
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
    
    /**
     * Get model instance
     *
     * @return Model
     */
    public function getModel(): Model;
}
