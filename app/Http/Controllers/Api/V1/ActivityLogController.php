<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\Activity\ActivityResource;
use App\Repositories\ActivityLog\Contracts\ActivityRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ActivityLogController extends BaseApiController
{
    public function __construct(
        protected readonly ActivityRepositoryInterface $activityRepo
    ) {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', \Spatie\Activitylog\Models\Activity::class);
    
        $logs = $this->activityRepo->paginateFiltered();
    
        return $this->successResponse(ActivityResource::collection($logs));
    }
    
}
