<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Vendors\VendorStoreRequest;
use App\Http\Requests\Api\V1\Vendors\VendorUpdateRequest;
use App\Http\Resources\Api\Vendor\VendorResource;
use App\Services\Contracts\VendorServiceInterface;
use Illuminate\Http\JsonResponse;

class VendorController extends BaseApiController
{
    public function __construct(
        protected readonly VendorServiceInterface $vendorService
    ) {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', \App\Models\Vendor::class);

        $vendors = $this->vendorService->getVendors();

        return $this->successResponse(VendorResource::collection($vendors));
    }

    public function show(int $id): JsonResponse
    {
        $vendor = $this->vendorService->getVendorById($id);
    
        $this->authorize('view', $vendor); // passing instance, bukan class
    
        return $this->successResponse(new VendorResource($vendor));
    }
    

    public function store(VendorStoreRequest $request): JsonResponse
    {
        $this->authorize('create', \App\Models\Vendor::class);
    
        $vendor = $this->vendorService->createVendor($request->validated());
    
        return $this->createdResponse(new VendorResource($vendor));
    }
    
    public function update(VendorUpdateRequest $request, int $id): JsonResponse
    {
        // ambil dulu vendor
        $vendor = $this->vendorService->getVendorById($id);
    
        // authorize pakai instance
        $this->authorize('update', $vendor);
    
        // lanjut update
        $vendor = $this->vendorService->updateVendor($id, $request->validated());
    
        return $this->successResponse(new VendorResource($vendor));
    }
    
    public function destroy(int $id): JsonResponse
    {
        $vendor = $this->vendorService->getVendorById($id);
    
        $this->authorize('delete', $vendor); // instance, bukan class
    
        $this->vendorService->deleteVendor($id);
    
        return $this->noContentResponse();
    }

    public function sync(): JsonResponse
    {
        // $this->authorize('sync', \App\Models\Vendor::class); // optional, buat policy sync

        try {
            $this->vendorService->syncToSpreadsheet();
            return $this->successResponse(['message' => 'Sinkronisasi vendor ke Google Sheet berhasil.']);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    
}
