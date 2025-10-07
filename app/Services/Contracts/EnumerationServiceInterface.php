<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface EnumerationServiceInterface
{
    public function getEnumerations(): Collection;

    public function getAllEnumerations(): Collection;

    public function getFilteredEnumerations(?Request $request = null, int $perPage = 15): LengthAwarePaginator;

    public function getEnumerationById(int $id): ?Model;

    public function createEnumeration(array $data): Model;

    public function updateEnumeration(int $id, array $data): Model;

    public function deleteEnumeration(int $id): bool;

    public function getActiveEnumerations(): Collection;
}
