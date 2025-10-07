<?php

namespace App\Repositories\Product\Concretes;

use App\Models\Product;
use App\Repositories\Base\Concretes\QueryableRepository;
use App\Repositories\Product\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use App\Services\Concretes\GoogleSheetService; // <— tambahkan ini

class ProductRepository extends QueryableRepository implements ProductRepositoryInterface
{


    /**
     * Tentukan model utama
     */
    protected function model(): string
    {
        return Product::class;
    }
   

    /**
     * Ambil semua produk dengan filter
     */
    public function getProducts(): Collection
    {
        return $this->getFiltered();
    }

    /**
     * Ambil hanya produk yang aktif
     */
    public function getActiveProducts(): Collection
    {
        return $this->model->where('is_active', 1)->get();
    }

    /**
     * Daftar filter yang diizinkan
     */
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            'name',
            'slug',
            AllowedFilter::exact('category_id'),
            AllowedFilter::exact('vendor_id'),
            'vendor_sku',
            'sku',
            'days',
            AllowedFilter::scope('price_min'),
            AllowedFilter::scope('price_max'),
            AllowedFilter::exact('is_active'),
        ];
    }

    /**
     * Daftar sorting yang diizinkan
     */
    public function getAllowedSorts(): array
    {
        return ['id', 'name', 'price', 'created_at'];
    }

    /**
     * Daftar relasi yang boleh di-include
     */
    public function getAllowedIncludes(): array
    {
        return [
            'category',
            'vendor',
        ];
    }

    /**
     * Daftar fields yang boleh diambil
     */
    public function getAllowedFields(): array
    {
        return [
            'id',
            'name',
            'slug',
            'category_id',
            'vendor_id',
            'vendor_sku',
            'sku',
            'days',
            'price',
            'description',
            'is_active',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }
}
