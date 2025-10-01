<?php

namespace App\Services\Concretes;

use App\Repositories\Product\Contracts\ProductRepositoryInterface;
use App\Services\Base\Concretes\BaseService;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService extends BaseService implements ProductServiceInterface
{
    public function __construct(protected ProductRepositoryInterface $productRepository)
    {
        $this->setRepository($productRepository);
    }

    public function getProducts(): Collection
    {
        return $this->repository->getFiltered();
    }

    public function getAllProducts(): Collection
    {
        return $this->repository->all();
    }

    public function getFilteredProducts(?Request $request = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginateFiltered($perPage);
    }

    public function getProductById(int $id): ?Model
    {
        try {
            return $this->repository->findOrFail($id);
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('Product not found');
        }
    }

    public function createProduct(array $data): Model
    {
        return $this->repository->create([
            'name'        => $data['name'],
            'slug'        => $data['slug'],
            'category_id' => $data['category_id'],
            'vendor_id'   => $data['vendor_id'],
            'vendor_sku'  => $data['vendor_sku'],
            'price'       => $data['price'],
            'description' => $data['description'] ?? null,
            'is_active'   => $data['is_active'] ?? true,
        ]);
    }

    public function updateProduct(int $id, array $data): Model
    {
        try {
            return $this->repository->update($id, [
                'name'        => $data['name'],
                'slug'        => $data['slug'],
                'category_id' => $data['category_id'],
                'vendor_id'   => $data['vendor_id'],
                'vendor_sku'  => $data['vendor_sku'],
                'price'       => $data['price'],
                'description' => $data['description'] ?? null,
                'is_active'   => $data['is_active'] ?? true,
            ]);
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('Product not found');
        }
    }

    public function deleteProduct(int $id): bool
    {
        try {
            $this->repository->findOrFail($id);
            return $this->repository->delete($id);
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('Product not found');
        }
    }

    public function getActiveProducts(): Collection
    {
        return $this->productRepository->getActiveProducts();
    }
}
