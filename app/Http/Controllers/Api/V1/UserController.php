<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\UserStoreRequest;
use App\Http\Requests\Api\V1\UserUpdateRequest;
use App\Http\Resources\Api\User\UserResource;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class UserController extends BaseApiController
{
    public function __construct(
        protected readonly UserServiceInterface $userService
    ) {}

    public function index(): JsonResponse
    {
        $this->authorize('view', \App\Models\User::class);

        $users = $this->userService->getFilteredUsers(request());

        return $this->successResponse(UserResource::collection($users));
    }

    public function all(): JsonResponse
    {
        $this->authorize('view', \App\Models\User::class);

        $users = $this->userService->getAllUsers();

        return $this->successResponse(UserResource::collection($users));
    }

    public function show(int $id): JsonResponse
    {
        $this->authorize('view', \App\Models\User::class);

        $user = $this->userService->getUserById($id);

        return $this->successResponse(new UserResource($user));
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $this->authorize('create', \App\Models\User::class);

        $user = $this->userService->createUser($request->validated());

        return $this->createdResponse(new UserResource($user));
    }

    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        $this->authorize('update', \App\Models\User::class);

        $user = $this->userService->updateUser($id, $request->validated());

        return $this->successResponse(new UserResource($user));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->authorize('delete', \App\Models\User::class);

        $this->userService->deleteUser($id);

        return $this->noContentResponse();
    }

    public function active(): JsonResponse
    {
        $this->authorize('view', \App\Models\User::class);

        $users = $this->userService->getActiveUsers();

        return $this->successResponse(UserResource::collection($users));
    }
}
