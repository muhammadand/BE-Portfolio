<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Permission\PermissionStoreRequest;
use App\Http\Requests\Api\V1\Permission\PermissionUpdateRequest;
use App\Http\Resources\Api\Permission\PermissionResource;
use App\Services\Contracts\PermissionServiceInterface;
use Illuminate\Http\JsonResponse;

class PermissionController extends BaseApiController
{
    public function __construct(
        protected readonly PermissionServiceInterface $permissionService
    ) {}

    public function index(): JsonResponse
    {
        $permissions = $this->permissionService->getAllPermissions();
        return $this->successResponse(PermissionResource::collection($permissions));
    }

    public function show(int $id): JsonResponse
    {
        $permission = $this->permissionService->getPermissionById($id);
        return $this->successResponse(new PermissionResource($permission));
    }

    public function store(PermissionStoreRequest $request): JsonResponse
    {
        $permission = $this->permissionService->createPermission($request->validated());
        return $this->createdResponse(new PermissionResource($permission));
    }

    public function update(PermissionUpdateRequest $request, int $id): JsonResponse
    {
        $permission = $this->permissionService->updatePermission($id, $request->validated());
        return $this->successResponse(new PermissionResource($permission));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->permissionService->deletePermission($id);
        return $this->noContentResponse();
    }
}
