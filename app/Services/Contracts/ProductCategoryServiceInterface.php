<?php

namespace App\Services\Contracts;

use App\Models\ProductCategory;

interface ProductCategoryServiceInterface
{
    public function getFilteredCategories(array $filters = []);

    public function getCategoryById(int $id): ProductCategory;

    public function createCategory(array $data): ProductCategory;

    public function updateCategory(int $id, array $data): ProductCategory;

    public function deleteCategory(int $id): void;
}
