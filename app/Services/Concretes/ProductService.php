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
use App\Models\Product;


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
            'sku'  => $data['sku'],
            'days'  => $data['days'],
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
                'sku'  => $data['sku'],
                'days'  => $data['days'],
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

    public function importFromSpreadsheet(string $spreadsheetId, string $range = 'FM!A1:F100'): \Illuminate\Support\Collection
    {
        $sheetService = new \App\Services\Concretes\GoogleSheetService($spreadsheetId);
        $rows = $sheetService->getSheetData($range);
    
        if (empty($rows) || count($rows) < 2) {
            throw new \Exception('Data kosong atau tidak ditemukan pada range yang diberikan.');
        }
    
        $header = array_map(fn($h) => strtolower(trim($h)), array_shift($rows));
        $rows = array_filter($rows, fn($r) => array_filter($r));
        $created = collect();
    
        foreach ($rows as $index => $row) {
            if (count($row) < count($header)) $row = array_pad($row, count($header), null);
            if (count($row) > count($header)) $row = array_slice($row, 0, count($header));
    
            $data = @array_combine($header, $row);
            if (!$data || empty(trim($data['nama produk'] ?? ''))) continue;
    
            $slugBase = \Str::slug($data['nama produk']);
            $slug = $slugBase;
            $counter = 1;
            while (\App\Models\Product::where('slug', $slug)->exists()) {
                $slug = "{$slugBase}-{$counter}";
                $counter++;
            }
    
            $product = $this->createProduct([
                'name' => $data['nama produk'],
                'slug' => $slug,
                'sku' => $data['sku'] ?? null,
                'vendor_sku' => $data['vendor_sku'] ?? $data['sku'] ?? $slug,
                'price' => is_numeric($data['price'] ?? null) ? (float)$data['price'] : 0,
                'days' => is_numeric($data['days'] ?? null) ? (int)$data['days'] : 0,
                'description' => $data['description'] ?? null,
                'category_id' => $this->resolveCategoryId($data['category'] ?? null),
                'vendor_id' => $this->resolveVendorId($data['vendor'] ?? null),
                'is_active' => true,
            ]);
            
    
            $created->push($product);
        }
    
        return $created;
    }
    



    private function resolveCategoryId(?string $categoryPath): ?int
    {
        if (empty($categoryPath)) {
            return null;
        }

        $parts = array_map('trim', explode('/', $categoryPath));

        // ambil parent name
        $parentName = $parts[0];
        $parent = \App\Models\ProductCategory::firstOrCreate(
            ['name' => $parentName],
            [
                'slug'        => \Str::slug($parentName),
                'description' => $parentName . ' main category',
            ]
        );

        // kalau tidak ada child, return parent id
        if (count($parts) === 1) {
            return $parent->id;
        }

        // ada child → ambil/buat child category
        $childName = $parts[1];
        $child = \App\Models\ProductCategory::firstOrCreate(
            [
                'name' => $childName,
                'parent_id' => $parent->id,
            ],
            [
                'slug'        => \Str::slug($childName),
                'description' => $childName . ' sub category',
            ]
        );

        return $child->id;
    }

    private function resolveVendorId(?string $vendorName): ?int
    {
        if (empty($vendorName)) {
            return null;
        }

        $vendorName = trim($vendorName);

        // Cari vendor berdasarkan name
        $vendor = \App\Models\Vendor::firstOrCreate(
            ['name' => $vendorName],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return $vendor->id;
    }
}
