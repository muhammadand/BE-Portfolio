<?php

namespace App\Services\Contracts;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Collection;

interface ProductCategoryServiceInterface
{
    public function getFilteredCategories(): Collection;

    public function getCategoryById(int $id): ProductCategory;

    public function createCategory(array $data): ProductCategory;

    public function updateCategory(int $id, array $data): ProductCategory;

    public function deleteCategory(int $id): void;
}
