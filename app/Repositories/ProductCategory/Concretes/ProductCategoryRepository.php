<?php

namespace App\Repositories\ProductCategory\Concretes;

use App\Models\ProductCategory;
use App\Repositories\Base\Concretes\QueryableRepository;
use App\Repositories\ProductCategory\Contracts\ProductCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class ProductCategoryRepository extends QueryableRepository implements ProductCategoryRepositoryInterface
{
    /**
     * Tentukan model utama
     */
    protected function model(): string
    {
        return ProductCategory::class;
    }

    /**
     * Ambil semua kategori (tanpa pagination)
     */
    public function getProductCategories(): Collection
    {
        return $this->getFiltered();
    }

    /**
     * Ambil kategori dengan pagination
     */
    public function paginateProductCategories(int $perPage = 15): LengthAwarePaginator
    {
        return $this->paginateFiltered($perPage);
    }

    /**
     * Daftar filter yang diizinkan
     */
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('parent_id'),
            'name',
            'slug',
        ];
    }

    /**
     * Daftar sorting yang diizinkan
     */
    public function getAllowedSorts(): array
    {
        return ['id', 'name', 'slug', 'created_at'];
    }

    /**
     * Daftar relasi yang boleh di-include
     */
    public function getAllowedIncludes(): array
    {
        return ['parent', 'children', 'products'];
    }

    /**
     * Daftar fields yang boleh diambil
     */
    public function getAllowedFields(): array
    {
        return [
            'id',
            'parent_id',
            'name',
            'slug',
            'description',
            'created_at',
            'updated_at',
        ];
    }
}
