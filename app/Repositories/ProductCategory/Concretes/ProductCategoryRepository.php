<?php

namespace App\Repositories\ProductCategory\Concretes;

use App\Models\ProductCategory;
use App\Repositories\Base\Concretes\QueryableRepository;
use App\Repositories\ProductCategory\Contracts\ProductCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;

class ProductCategoryRepository extends QueryableRepository implements ProductCategoryRepositoryInterface
{
    protected function model(): string
    {
        return ProductCategory::class;
    }

    public function getProductCategories(): Collection
    {
        return $this->getFiltered();
    }

    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('parent_id'),
            'name',
            'slug',
        ];
    }

    public function getAllowedSorts(): array
    {
        return ['id', 'name', 'slug', 'created_at'];
    }

    public function getAllowedIncludes(): array
    {
        return ['parent', 'children', 'products'];
    }

    public function getAllowedFields(): array
    {
        return ['id', 'parent_id', 'name', 'slug', 'description', 'created_at', 'updated_at'];
    }
}
