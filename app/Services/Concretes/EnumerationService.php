<?php

namespace App\Services\Concretes;

use App\Repositories\Enumeration\Contracts\EnumerationRepositoryInterface;
use App\Services\Base\Concretes\BaseService;
use App\Services\Contracts\EnumerationServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class EnumerationService extends BaseService implements EnumerationServiceInterface
{
    public function __construct(protected EnumerationRepositoryInterface $enumerationRepository)
    {
        $this->setRepository($enumerationRepository);
    }

    public function getEnumerations(): Collection
    {
        return $this->repository->getFiltered();
    }

    public function getAllEnumerations(): Collection
    {
        return $this->repository->all();
    }

    public function getFilteredEnumerations(?Request $request = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginateFiltered($perPage);
    }

    public function getEnumerationById(int $id): ?Model
    {
        try {
            return $this->repository->findOrFail($id);
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('Enumeration not found');
        }
    }

    public function createEnumeration(array $data): Model
    {
        return $this->repository->create([
            'label' => $data['label'],
            'name'  => $data['name'],
            'value' => $data['value'],
            'group' => $data['group'] ?? null,
        ]);
    }

    public function updateEnumeration(int $id, array $data): Model
    {
        try {
            $enum = $this->repository->update($id, [
                'label' => $data['label'],
                'name'  => $data['name'],
                'value' => $data['value'],
                'group' => $data['group'] ?? null,
            ]);

            return $this->getEnumerationById($id);
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('Enumeration not found');
        }
    }

    public function deleteEnumeration(int $id): bool
    {
        try {
            $this->getEnumerationById($id);
            return $this->repository->delete($id);
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('Enumeration not found');
        }
    }

    public function getActiveEnumerations(): Collection
    {
        return $this->enumerationRepository->getActiveEnumerations();
    }
}
