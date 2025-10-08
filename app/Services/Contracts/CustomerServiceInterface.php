<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerServiceInterface
{
    public function getCustomers(): Collection;

    public function getAllCustomers(): Collection;

    public function getFilteredCustomers(?Request $request = null, int $perPage = 15): LengthAwarePaginator;

    public function getCustomerById(int $id): ?Model;

    public function createCustomer(array $data): Model;

    public function updateCustomer(int $id, array $data): Model;

    public function deleteCustomer(int $id): bool;
}
