<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function getProducts(): Collection;

    public function getAllProducts(): Collection;

    public function getFilteredProducts(?Request $request = null, int $perPage = 15): LengthAwarePaginator;

    public function getProductById(int $id): ?Model;

    public function createProduct(array $data): Model;

    public function updateProduct(int $id, array $data): Model;

    public function deleteProduct(int $id): bool;

    public function getActiveProducts(): Collection;

        /**
     * Import products from Google Spreadsheet.
     *
     * @param string $spreadsheetId
     * @param string|null $range
     * @return \Illuminate\Support\Collection
     */
    public function importFromSpreadsheet(string $spreadsheetId, string $range = 'MM!A1:F10'): \Illuminate\Support\Collection;
}
