<?php

namespace App\Services\Contracts;

use App\Models\ProductCategory;
use App\Services\Base\Contracts\BaseServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProductCategoryServiceInterface extends BaseServiceInterface
{
    /**
     * Get filtered product categories with pagination, sorting, etc.
     */
    public function getFilteredCategories($request): LengthAwarePaginator;

    /**
     * Get all product categories (without pagination).
     */
    public function getAllCategories(): Collection;

    /**
     * Get a single product category by ID.
     */
    public function getCategoryById(int $id): ProductCategory;

    /**
     * Create a new product category.
     */
    public function createCategory(array $data): ProductCategory;

    /**
     * Update an existing product category.
     */
    public function updateCategory(int $id, array $data): ProductCategory;

    /**
     * Delete a product category by ID.
     */
    public function deleteCategory(int $id): bool;
}
