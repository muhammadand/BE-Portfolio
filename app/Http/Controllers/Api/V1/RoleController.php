<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Role\RoleStoreRequest;
use App\Http\Requests\Api\V1\Role\RoleUpdateRequest;
use App\Http\Resources\Api\Role\RoleResource;
use App\Services\Contracts\RoleServiceInterface;
use Illuminate\Http\JsonResponse;

class RoleController extends BaseApiController
{
    public function __construct(
        protected readonly RoleServiceInterface $roleService
    ) {}

    public function index(): JsonResponse
    {
        $roles = $this->roleService->getAllRoles();
        return $this->successResponse(RoleResource::collection($roles));
    }

    public function show(int $id): JsonResponse
    {
        $role = $this->roleService->getRoleById($id);
        return $this->successResponse(new RoleResource($role));
    }

    public function store(RoleStoreRequest $request): JsonResponse
    {
        $role = $this->roleService->createRole($request->validated());
        return $this->createdResponse(new RoleResource($role));
    }

    public function update(RoleUpdateRequest $request, int $id): JsonResponse
    {
        $role = $this->roleService->updateRole($id, $request->validated());
        return $this->successResponse(new RoleResource($role));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->roleService->deleteRole($id);
        return $this->noContentResponse();
    }
}
