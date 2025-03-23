<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\UserCollection;
use App\Http\Resources\Api\UserResource;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends BaseApiController
{
    /**
     * UserController constructor.
     */
    public function __construct(
        protected readonly UserServiceInterface $userService
    ) {}

    /**
     * Display a listing of the users.
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return $this->successResponse(new UserCollection($users), 'Users retrieved successfully');
    }

    /**
     * Display the specified user.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->userService->getUserById($id);
            return $this->successResponse(new UserResource($user), 'User retrieved successfully');
        } catch (ModelNotFoundException) {
            return $this->notFoundResponse('User not found');
        }
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $user = $this->userService->createUser($request->all());
            return $this->createdResponse(new UserResource($user));
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $user = $this->userService->updateUser($id, $request->all());
            return $this->successResponse(new UserResource($user), 'User updated successfully');
        } catch (ModelNotFoundException) {
            return $this->notFoundResponse('User not found');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $result = $this->userService->deleteUser($id);
            if ($result) {
                return $this->noContentResponse();
            }
            return $this->errorResponse('Failed to delete user');
        } catch (ModelNotFoundException) {
            return $this->notFoundResponse('User not found');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    
    /**
     * Display a listing of active users.
     */
    public function active(): JsonResponse
    {
        $users = $this->userService->getActiveUsers();
        return $this->successResponse(new UserCollection($users), 'Active users retrieved successfully');
    }
}
