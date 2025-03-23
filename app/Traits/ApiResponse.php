<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse
{
    /**
     * Return a success JSON response.
     *
     * @param array|JsonResource|ResourceCollection|LengthAwarePaginator|null $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse($data = null, string $message = null, int $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'status' => $code,
        ];

        if ($message) {
            $response['message'] = $message;
        }

        if ($data instanceof ResourceCollection && $data->resource instanceof LengthAwarePaginator) {
            $response['data'] = $data->collection;
            $response['pagination'] = [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
            ];
        } elseif ($data instanceof LengthAwarePaginator) {
            $response['data'] = $data->items();
            $response['pagination'] = [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
            ];
        } elseif ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param string $message
     * @param int $code
     * @param array|null $errors
     * @return JsonResponse
     */
    protected function errorResponse(string $message, int $code = 400, array $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'status' => $code,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Return a 201 Created response.
     *
     * @param array|JsonResource|null $data
     * @param string|null $message
     * @return JsonResponse
     */
    protected function createdResponse($data = null, string $message = null): JsonResponse
    {
        return $this->successResponse($data, $message ?? 'Resource created successfully', 201);
    }

    /**
     * Return a 204 No Content response.
     *
     * @return JsonResponse
     */
    protected function noContentResponse(): JsonResponse
    {
        return response()->json(null, 204);
    }

    /**
     * Return a 404 Not Found response.
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    /**
     * Return a 403 Forbidden response.
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function forbiddenResponse(string $message = 'Forbidden'): JsonResponse
    {
        return $this->errorResponse($message, 403);
    }

    /**
     * Return a 401 Unauthorized response.
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->errorResponse($message, 401);
    }

    /**
     * Return a 422 Validation Error response.
     *
     * @param array $errors
     * @param string $message
     * @return JsonResponse
     */
    protected function validationErrorResponse(array $errors, string $message = 'Validation failed'): JsonResponse
    {
        return $this->errorResponse($message, 422, $errors);
    }
}
