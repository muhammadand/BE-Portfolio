<?php

namespace App\Services\Concretes;

use App\Models\ProductCategory;
use App\Services\Contracts\ProductCategoryServiceInterface;
use App\Repositories\ProductCategory\Contracts\ProductCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductCategoryService implements ProductCategoryServiceInterface
{
    public function __construct(
        protected readonly ProductCategoryRepositoryInterface $productCategoryRepository
    ) {}

    public function getFilteredCategories(): Collection
    {
        // panggil repository supaya filter/sort/include otomatis
        return $this->productCategoryRepository->getProductCategories();
    }

    public function getCategoryById(int $id): ProductCategory
    {
        return $this->productCategoryRepository->find($id);
    }

    public function createCategory(array $data): ProductCategory
    {
        return $this->productCategoryRepository->create($data);
    }

    public function updateCategory(int $id, array $data): ProductCategory
    {
        return $this->productCategoryRepository->update($id, $data);
    }

    public function deleteCategory(int $id): void
    {
        $this->productCategoryRepository->delete($id);
    }
}
