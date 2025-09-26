<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ActivityLog;
use App\Http\Resources\Api\logs\ActivityLogResource;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseApiController;

class ActivityLogController extends BaseApiController
{
    public function index(): JsonResponse
    {
        $logs = ActivityLog::with('causer')->latest()->paginate(20);
        return response()->json(ActivityLogResource::collection($logs));
    }

    public function show(ActivityLog $activityLog): JsonResponse
    {
        $activityLog->load('causer');
        return response()->json(new ActivityLogResource($activityLog));
    }

    public function destroy(ActivityLog $activityLog): JsonResponse
    {
        $activityLog->delete();
        return response()->json(null, 204);
    }
}
