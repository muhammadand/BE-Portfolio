<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Enumeration\EnumerationStoreRequest;
use App\Http\Requests\Api\V1\Enumeration\EnumerationUpdateRequest;
use App\Http\Resources\Api\Enumeration\EnumerationResource;

use App\Services\Contracts\EnumerationServiceInterface;
use Illuminate\Http\JsonResponse;

class EnumerationController extends BaseApiController
{
    public function __construct(
        protected readonly EnumerationServiceInterface $enumerationService
    ) {}

    public function index(): JsonResponse
    {
        $this->authorize('view', \App\Models\Enumeration::class);

        $enumerations = $this->enumerationService->getFilteredEnumerations(request());

        return $this->successResponse(EnumerationResource::collection($enumerations));
    }

    public function show(int $id): JsonResponse
    {
        $enum = $this->enumerationService->getEnumerationById($id);
        $this->authorize('view', $enum);

        return $this->successResponse(new EnumerationResource($enum));
    }

    public function store(EnumerationStoreRequest $request): JsonResponse
    {
        $this->authorize('create', \App\Models\Enumeration::class);

        $enum = $this->enumerationService->createEnumeration($request->validated());

        return $this->createdResponse(new EnumerationResource($enum));
    }

    public function update(EnumerationUpdateRequest $request, int $id): JsonResponse
    {
        $enum = $this->enumerationService->getEnumerationById($id);
        $this->authorize('update', $enum);

        $enum = $this->enumerationService->updateEnumeration($id, $request->validated());

        return $this->successResponse(new EnumerationResource($enum));
    }

    public function destroy(int $id): JsonResponse
    {
        $enum = $this->enumerationService->getEnumerationById($id);
        $this->authorize('delete', $enum);

        $this->enumerationService->deleteEnumeration($id);

        return $this->noContentResponse();
    }
}
