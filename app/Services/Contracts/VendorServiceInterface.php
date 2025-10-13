<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface VendorServiceInterface
{
    public function getVendors(): Collection;

    public function getVendorById(int $id): ?Model;

    public function createVendor(array $data): Model;

    public function updateVendor(int $id, array $data): Model;

    /**
     * Sinkronisasi semua vendor ke Google Spreadsheet
     *
     * @return bool
     * @throws \Exception
     */
    public function syncToSpreadsheet(): bool;
    public function deleteVendor(int $id): bool;
}
