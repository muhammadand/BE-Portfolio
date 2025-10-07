<?php

namespace App\Repositories\Enumeration\Concretes;

use App\Models\Enumeration;
use App\Repositories\Base\Concretes\QueryableRepository;
use App\Repositories\Enumeration\Contracts\EnumerationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;

class EnumerationRepository extends QueryableRepository implements EnumerationRepositoryInterface
{
    protected function model(): string
    {
        return Enumeration::class;
    }

    public function getEnumerations(): Collection
    {
        return $this->getFiltered();
    }

    public function getActiveEnumerations(): Collection
    {
        return $this->model->where('is_active', 1)->get();
    }

    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            'label',
            'name',
            'group',
        ];
    }

    public function getAllowedSorts(): array
    {
        return ['id', 'label', 'name'];
    }

    public function getAllowedIncludes(): array
    {
        return []; // bisa ditambahkan relasi jika ada
    }

    public function getAllowedFields(): array
    {
        return ['id', 'label', 'name', 'value', 'group'];
    }
}
