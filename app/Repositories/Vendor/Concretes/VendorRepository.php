<?php

namespace App\Repositories\Vendor\Concretes;

use App\Models\Vendor;
use App\Repositories\Base\Concretes\QueryableRepository;
use App\Repositories\Vendor\Contracts\VendorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;

class VendorRepository extends QueryableRepository implements VendorRepositoryInterface
{
    /**
     * Specify Model class name
     */
    protected function model(): string
    {
        return Vendor::class;
    }

    /**
     * Return All Vendors (with filters/sorts/includes if provided)
     */
    public function getVendors(): Collection
    {
        return $this->getFiltered();
    }

    /**
     * Get allowed filters for this repository.
     */
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            'name',
        ];
    }

    /**
     * Get allowed sorts for this repository.
     */
    public function getAllowedSorts(): array
    {
        return ['id', 'name'];
    }

    /**
     * Get allowed includes for this repository.
     */
    public function getAllowedIncludes(): array
    {
        // relasi products dari model Vendor
        return ['products'];
    }

    /**
     * Get allowed fields for this repository.
     */
    public function getAllowedFields(): array
    {
        return ['id', 'name', 'created_at', 'updated_at'];
    }
}
