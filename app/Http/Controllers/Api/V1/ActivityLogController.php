<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\ActivityLog\Contracts\ActivityRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ActivityLogController extends BaseApiController
{
    public function __construct(
        protected readonly ActivityRepositoryInterface $activityRepo
    ) {}

    public function index(): JsonResponse
    {
        $filters = request()->only(['user_id', 'model', 'from', 'to', 'sort', 'include', 'fields']);

        $logs = $this->activityRepo->getActivities($filters);

        return $this->successResponse($logs);
    }
}
