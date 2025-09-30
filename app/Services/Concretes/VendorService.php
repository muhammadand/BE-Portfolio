<?php

namespace App\Services\Concretes;

use App\Services\Contracts\VendorServiceInterface;
use App\Repositories\Vendor\Contracts\VendorRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class VendorService implements VendorServiceInterface
{
    protected VendorRepositoryInterface $repository;

    public function __construct(VendorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get vendors with filters, sorts, includes, etc.
     */
    public function getVendors(): Collection
    {
        return $this->repository->getVendors();
    }

    public function getVendorById(int $id): ?Model
    {
        return $this->repository->find($id);
    }

    public function createVendor(array $data): Model
    {
        return $this->repository->create($data);
    }

    public function updateVendor(int $id, array $data): Model
    {
        return $this->repository->update($id, $data);
    }

    public function deleteVendor(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
