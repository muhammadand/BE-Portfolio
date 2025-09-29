<?php

namespace App\Repositories\ActivityLog\Concretes;

use App\Repositories\ActivityLog\Contracts\ActivityRepositoryInterface;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ActivityRepository implements ActivityRepositoryInterface
{
    protected function model(): string
    {
        return Activity::class;
    }

    public function getActivities(array $filters = []): Collection
    {
        $query = QueryBuilder::for($this->model())
            ->allowedFilters($this->getAllowedFilters())
            ->allowedSorts($this->getAllowedSorts())
            ->allowedIncludes($this->getAllowedIncludes())
            ->latest();

        // Tambahan filter manual dari array $filters
        if (!empty($filters['user_id'])) {
            $query->where('causer_id', $filters['user_id']);
        }
        if (!empty($filters['model'])) {
            $query->where('subject_type', $filters['model']);
        }
        if (!empty($filters['from'])) {
            $query->whereDate('created_at', '>=', $filters['from']);
        }
        if (!empty($filters['to'])) {
            $query->whereDate('created_at', '<=', $filters['to']);
        }

        return $query->get();
    }

    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('causer_id'),
            AllowedFilter::exact('subject_id'),
            AllowedFilter::exact('subject_type'),
            'log_name',
            'description',
            'event',
        ];
    }

    public function getAllowedSorts(): array
    {
        return ['id', 'created_at', 'updated_at'];
    }

    public function getAllowedIncludes(): array
    {
        return ['causer', 'subject'];
    }

    public function getAllowedFields(): array
    {
        return ['id', 'log_name', 'description', 'subject_type', 'subject_id', 'causer_id', 'properties', 'created_at', 'updated_at'];
    }
}
