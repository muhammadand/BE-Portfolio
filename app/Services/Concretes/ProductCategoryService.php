<?php

namespace App\Services\Concretes;

use App\Models\ProductCategory;
use App\Services\Contracts\ProductCategoryServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

use App\Services\Base\Concretes\BaseService;

class ProductCategoryService extends BaseService implements ProductCategoryServiceInterface
{
    public function getFilteredCategories($request): LengthAwarePaginator
    {
        return ProductCategory::query()->paginate(15);
    }

    public function getAllCategories(): Collection
    {
        return ProductCategory::all();
    }

    public function getCategoryById(int $id): ProductCategory
    {
        return ProductCategory::findOrFail($id);
    }

    public function createCategory(array $data): ProductCategory
    {
        return ProductCategory::create($data);
    }

    public function updateCategory(int $id, array $data): ProductCategory
    {
        $category = ProductCategory::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function deleteCategory(int $id): bool
    {
        $category = ProductCategory::findOrFail($id);
        return $category->delete();
    }
}
