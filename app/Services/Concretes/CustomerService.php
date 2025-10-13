<?php

namespace App\Services\Concretes;

use App\Repositories\Customer\Contracts\CustomerRepositoryInterface;
use App\Services\Contracts\CustomerServiceInterface;
use App\Services\Base\Concretes\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService extends BaseService implements CustomerServiceInterface
{
    public function __construct(protected CustomerRepositoryInterface $customerRepository)
    {
        $this->setRepository($customerRepository);
    }

    public function getCustomers(): Collection
    {
        return $this->repository->getFiltered();
    }

    public function getAllCustomers(): Collection
    {
        return $this->repository->all();
    }

    public function getFilteredCustomers(?Request $request = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginateFiltered($perPage);
    }

    public function getCustomerById(int $id): ?Model
    {
        try {
            return $this->repository->findOrFail($id);
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('Customer not found');
        }
    }

    public function createCustomer(array $data): Model
    {
        return $this->repository->create($data);
    }

    public function updateCustomer(int $id, array $data): Model
    {
        try {
            return $this->repository->update($id, $data);
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('Customer not found');
        }
    }

    public function deleteCustomer(int $id): bool
    {
        try {
            $this->repository->findOrFail($id);
            $this->repository->delete($id);
            return true;
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('Customer not found');
        }
    }
}
