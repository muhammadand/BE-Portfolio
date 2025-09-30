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
        $this->authorize('view', \App\Models\Vendor::class);

        $vendor = $this->vendorService->getVendorById($id);

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
        $this->authorize('update', \App\Models\Vendor::class);

        $vendor = $this->vendorService->updateVendor($id, $request->validated());

        return $this->successResponse(new VendorResource($vendor));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->authorize('delete', \App\Models\Vendor::class);

        $this->vendorService->deleteVendor($id);

        return $this->noContentResponse();
    }
}
