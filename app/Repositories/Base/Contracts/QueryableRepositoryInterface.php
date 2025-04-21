<?php

namespace App\Repositories\Base\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

interface QueryableRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get a query builder instance with filters, sorts, and includes applied.
     *
     * @return QueryBuilder
     */
    public function query(): QueryBuilder;

    /**
     * Get filtered, sorted, and included resources.
     *
     * @param array $columns
     * @return Collection
     */
    public function getFiltered(array $columns = ['*']): Collection;

    /**
     * Get paginated, filtered, sorted, and included resources.
     *
     * @param int $perPage
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginateFiltered(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    /**
     * Get allowed filters for this repository.
     *
     * @return array
     */
    public function getAllowedFilters(): array;

    /**
     * Get allowed sorts for this repository.
     *
     * @return array
     */
    public function getAllowedSorts(): array;

    /**
     * Get allowed includes for this repository.
     *
     * @return array
     */
    public function getAllowedIncludes(): array;

    /**
     * Get allowed fields for this repository.
     *
     * @return array
     */
    public function getAllowedFields(): array;
}
