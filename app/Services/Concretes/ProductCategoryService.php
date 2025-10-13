<?php

namespace App\Services\Concretes;

use App\Models\ProductCategory;
use App\Services\Contracts\ProductCategoryServiceInterface;
use App\Repositories\ProductCategory\Contracts\ProductCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductCategoryService implements ProductCategoryServiceInterface
{
    public function __construct(
        protected readonly ProductCategoryRepositoryInterface $productCategoryRepository
    ) {}

    protected string $spreadsheetId = '1jkJBxZI7glXCU7pPyt_iSx8D0nhEbaZcsdlYwFWVZhU';
    protected string $sheetRange = 'Referensi!A1:D';

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
        return DB::transaction(function () use ($data) {
            // 🔹 Generate slug otomatis jika kosong
            if (empty($data['slug'])) {
                $data['slug'] = $this->generateUniqueSlug($data['name']);
            }

    
            // 1️⃣ Simpan kategori ke DB saja (tanpa sinkron ke spreadsheet)
            $category = $this->productCategoryRepository->create($data);
    
            return $category;
        });
    }
    
    protected function generateUniqueSlug(string $name): string
    {
        $slugBase = \Str::slug($name);
        $slug = $slugBase;
        $counter = 1;
    
        while (ProductCategory::where('slug', $slug)->exists()) {
            $slug = "{$slugBase}-{$counter}";
            $counter++;
        }
    
        return $slug;
    }
    

    public function updateCategory(int $id, array $data): Model
    {
        return $this->productCategoryRepository->update($id, $data);
    }

    public function deleteCategory(int $id): bool
    {
        return $this->productCategoryRepository->delete($id);
    }



    public function syncToSpreadsheet(): bool
    {
        $sheetService = new \App\Services\Concretes\GoogleSheetService($this->spreadsheetId);
    
        $range = 'Category!A1:C';
    
        $categories = \App\Models\ProductCategory::all(['id', 'parent_id', 'name']);
    
        if ($categories->isEmpty()) {
            throw new \Exception('Tidak ada kategori produk di database untuk disinkronkan.');
        }
    
        // Header sesuai yang ada di sheet
        $header = ['id', 'parent_id', 'name'];
    
        // Pastikan data dikonversi ke array numerik (bukan associative)
        $rows = $categories->map(function ($cat) {
            return [
                (string) $cat->id,
                $cat->parent_id ? (string) $cat->parent_id : '',
                (string) $cat->name,
            ];
        })->values()->toArray();
    
        // Gabungkan header + isi data
        $values = array_merge([$header], $rows);
    
        // Kosongkan isi lama
        $sheetService->clearSheet($range);
    
        // ✅ Pastikan semua data berupa list of lists
        $values = array_map('array_values', $values);
    
        // Tulis data baru
        $sheetService->updateSheetData($range, $values);
    
        return true;
    }
    

}
