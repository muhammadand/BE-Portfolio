<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

trait ServiceResponse
{
    use ApiResponse;
    
    /**
     * Format collection response
     */
    protected function formatCollectionResponse(
        $data, 
        string $resourceClass, 
        string $message = null
    ): JsonResponse {
        return $this->successResponse(
            new $resourceClass($data),
            $message
        );
    }
    
    /**
     * Format single resource response
     */
    protected function formatResourceResponse(
        $data, 
        string $resourceClass, 
        string $message = null
    ): JsonResponse {
        return $this->successResponse(
            new $resourceClass($data),
            $message
        );
    }
    
    /**
     * Format created response
     */
    protected function formatCreatedResponse(
        $data, 
        string $resourceClass, 
        string $message = null
    ): JsonResponse {
        return $this->createdResponse(
            new $resourceClass($data),
            $message
        );
    }
    
    /**
     * Format deleted response
     */
    protected function formatDeletedResponse(): JsonResponse {
        return $this->noContentResponse();
    }
}
