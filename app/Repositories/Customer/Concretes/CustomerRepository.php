<?php

namespace App\Repositories\Customer\Concretes;

use App\Models\Customer;
use App\Repositories\Base\Concretes\QueryableRepository;
use App\Repositories\Customer\Contracts\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;

class CustomerRepository extends QueryableRepository implements CustomerRepositoryInterface
{
    protected function model(): string
    {
        return Customer::class;
    }

    public function getCustomers(): Collection
    {
        return $this->getFiltered();
    }

    public function getActiveCustomers(): Collection
    {
        return $this->model->whereNotNull('email')->get(); // contoh filter aktif
    }

    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            'name',
            'email',
            'phone',
            AllowedFilter::exact('channel_id'),
        ];
    }

    public function getAllowedSorts(): array
    {
        return ['id', 'name', 'email', 'phone'];
    }

    public function getAllowedIncludes(): array
    {
        return ['channel'];
    }

    public function getAllowedFields(): array
    {
        return ['id', 'name', 'email', 'phone', 'channel_id'];
    }
}
