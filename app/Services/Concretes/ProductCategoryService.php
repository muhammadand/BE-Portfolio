<?php

namespace App\Services\Concretes;

use App\Models\ProductCategory;
use App\Services\Contracts\ProductCategoryServiceInterface;

class ProductCategoryService implements ProductCategoryServiceInterface
{
    public function getFilteredCategories(array $filters = [])
    {
        $query = ProductCategory::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', "%{$filters['name']}%");
        }

        return $query->get();
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

    public function deleteCategory(int $id): void
    {
        $category = ProductCategory::findOrFail($id);
        $category->delete();
    }
}
