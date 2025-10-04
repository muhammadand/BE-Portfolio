<?php

namespace App\Services\Concretes;

use App\Models\ProductCategory;
use App\Services\Contracts\ProductCategoryServiceInterface;
use App\Repositories\ProductCategory\Contracts\ProductCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductCategoryService implements ProductCategoryServiceInterface
{
    public function __construct(
        protected readonly ProductCategoryRepositoryInterface $productCategoryRepository
    ) {}

    public function getCategories(): Collection
    {
        return $this->productCategoryRepository->all();
    }

    public function getAllCategories(): Collection
    {
        return $this->productCategoryRepository->all();
    }

    public function getFilteredCategories(?Request $request = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->productCategoryRepository->paginateFiltered($perPage);
    }

    public function getCategoryById(int $id): ?Model
    {
        return $this->productCategoryRepository->find($id);
    }

    public function createCategory(array $data): Model
    {
        return $this->productCategoryRepository->create($data);
    }

    public function updateCategory(int $id, array $data): Model
    {
        return $this->productCategoryRepository->update($id, $data);
    }

    public function deleteCategory(int $id): bool
    {
        return $this->productCategoryRepository->delete($id);
    }
}
