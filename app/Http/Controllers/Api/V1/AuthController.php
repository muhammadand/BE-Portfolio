<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Resources\Api\V1\Auth\AuthUserResource;
use App\Services\Contracts\AuthServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * AuthController constructor.
     */
    public function __construct(
        private readonly AuthServiceInterface $authService
    ) {
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $token = $this->authService->register($request->validated());
        
        return $this->successResponse([
            'token' => $token,
            'token_type' => 'bearer',
        ], Response::HTTP_CREATED);
    }

    /**
     * Login a user.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->validated());
        
        return $this->successResponse([
            'token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    /**
     * Get the authenticated user.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $user = $this->authService->me();
        
        return $this->successResponse(new AuthUserResource($user));
    }

    /**
     * Refresh the token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $token = $this->authService->refresh();
        
        return $this->successResponse([
            'token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    /**
     * Logout the user.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout();
        
        return $this->successResponse(['message' => 'Successfully logged out']);
    }
}
