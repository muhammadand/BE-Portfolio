<?php

namespace App\Services\Concretes;

use App\Services\Contracts\VendorServiceInterface;
use App\Repositories\Vendor\Contracts\VendorRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class VendorService implements VendorServiceInterface
{
    protected VendorRepositoryInterface $repository;
    protected string $spreadsheetId;
    public function __construct(VendorRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->spreadsheetId = env('GOOGLE_SHEET_ID');
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


    public function syncToSpreadsheet(): bool
    {
        $sheetService = new \App\Services\Concretes\GoogleSheetService($this->spreadsheetId);
    
        // Range sheet untuk vendor
        $range = 'Vendor!A1:B'; // Cukup dua kolom: id dan name
    
        // Ambil semua vendor dari database
        $vendors = \App\Models\Vendor::all(['id', 'name']);
    
        if ($vendors->isEmpty()) {
            throw new \Exception('Tidak ada vendor di database untuk disinkronkan.');
        }
    
        // Header sesuai sheet
        $header = ['id', 'name'];
    
        // Ubah data jadi array numerik
        $rows = $vendors->map(function ($vendor) {
            return [
                (string) $vendor->id,
                (string) $vendor->name,
            ];
        })->values()->toArray();
    
        // Gabungkan header + isi data
        $values = array_merge([$header], $rows);
    
        // Kosongkan sheet dulu
        $sheetService->clearSheet($range);
    
        // Pastikan semua baris berupa list numerik
        $values = array_map('array_values', $values);
    
        // Tulis data baru ke sheet
        $sheetService->updateSheetData($range, $values);
    
        return true;
    }
    
}
