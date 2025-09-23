<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\UserStoreRequest;
use App\Http\Requests\Api\V1\UserUpdateRequest;
use App\Http\Resources\Api\User\UserResource;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseApiController
{
    public function __construct(
        protected readonly UserServiceInterface $userService
    ) {}

    private function checkPermission(string $permission)
    {
        $user = Auth::user();

        if (!$user || !$user->all_permissions->contains('slug', $permission)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return true;
    }

    public function index(): JsonResponse
    {
        $response = $this->checkPermission('view_users');
        if ($response !== true) return $response;

        $users = $this->userService->getFilteredUsers(request());

        return $this->successResponse(UserResource::collection($users));
    }

    public function all(): JsonResponse
    {
        $response = $this->checkPermission('view_users');
        if ($response !== true) return $response;

        $users = $this->userService->getAllUsers();

        return $this->successResponse(UserResource::collection($users));
    }

    public function show(int $id): JsonResponse
    {
        $response = $this->checkPermission('view_users');
        if ($response !== true) return $response;

        $user = $this->userService->getUserById($id);

        return $this->successResponse(new UserResource($user));
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $response = $this->checkPermission('create_users');
        if ($response !== true) return $response;

        $user = $this->userService->createUser($request->validated());

        return $this->createdResponse(new UserResource($user));
    }

    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        $response = $this->checkPermission('edit_users');
        if ($response !== true) return $response;

        $user = $this->userService->updateUser($id, $request->validated());

        return $this->successResponse(new UserResource($user));
    }

    public function destroy(int $id): JsonResponse
    {
        $response = $this->checkPermission('delete_users');
        if ($response !== true) return $response;

        $this->userService->deleteUser($id);

        return $this->noContentResponse();
    }

    public function active(): JsonResponse
    {
        $response = $this->checkPermission('view_users');
        if ($response !== true) return $response;

        $users = $this->userService->getActiveUsers();

        return $this->successResponse(UserResource::collection($users));
    }
}
