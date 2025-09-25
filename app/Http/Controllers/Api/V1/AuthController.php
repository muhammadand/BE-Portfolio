<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Resources\Api\User\UserResource;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseApiController
{
    /**
     * AuthController constructor.
     */
    public function __construct(
        private readonly AuthServiceInterface $authService
    ) {}

    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // Mendapatkan data yang sudah divalidasi termasuk role
        $data = $request->validated();
    

    
        // Mendaftarkan pengguna dengan data yang telah diterima
        $user = $this->authService->register($data);
    
        // Mengembalikan response sukses dengan data pengguna yang baru didaftarkan
        return $this->successResponse($user);
    }
    

    /**
     * Login a user.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Mengambil data login dari request
        $data = $this->authService->login($request->validated());
    
        // Mengembalikan response sukses dengan pesan "Login successful"
        return $this->successResponse([
            'message' => 'Login successful',  // Menambahkan pesan login sukses
            'user' => $data['user'],          // Data pengguna
            'token' => $data['token'],        // JWT token
            'token_type' => $data['token_type'] // Tipe token, biasanya 'bearer'
        ]);
    }
    

    /**
     * Get the authenticated user.
     */
    public function me(): JsonResponse
    {
        $user = $this->authService->me();

        return $this->successResponse(new UserResource($user));
    }

    /**
     * Refresh the token.
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
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return $this->successResponse(['message' => 'Successfully logged out']);
    }
}
