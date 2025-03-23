<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only modify JSON responses
        if (!$response instanceof JsonResponse) {
            return $response;
        }

        $data = $response->getData(true);

        // If the response is already in our standard format, return it
        if (isset($data['success']) && (isset($data['status']) || isset($data['data']) || isset($data['message']))) {
            return $response;
        }

        // Transform the response to our standard format
        $statusCode = $response->getStatusCode();
        $success = $statusCode < 400;

        $transformed = [
            'success' => $success,
            'status' => $statusCode,
        ];

        // Add message based on status code
        if (!$success) {
            $transformed['message'] = $this->getDefaultMessageForStatusCode($statusCode);
        }

        // Add data if present
        if (!empty($data)) {
            $transformed['data'] = $data;
        }

        $response->setData($transformed);

        return $response;
    }

    /**
     * Get default message for HTTP status code.
     *
     * @param int $statusCode
     * @return string
     */
    protected function getDefaultMessageForStatusCode(int $statusCode): string
    {
        return match ($statusCode) {
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            405 => 'Method not allowed',
            422 => 'Validation failed',
            429 => 'Too many requests',
            500 => 'Server error',
            503 => 'Service unavailable',
            default => 'Error',
        };
    }
}
