<?php

namespace App\Repositories\ActivityLog\Concretes;

use App\Repositories\Base\Concretes\QueryableRepository;
use App\Repositories\ActivityLog\Contracts\ActivityRepositoryInterface;
use Spatie\Activitylog\Models\Activity;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Collection;

class ActivityRepository extends QueryableRepository implements ActivityRepositoryInterface
{
    protected function model(): string
    {
        return Activity::class;
    }

    public function getActivities(): Collection
    {
        return $this->getFiltered();
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
            AllowedFilter::callback('date_range', function ($query, $value) {
                if (isset($value['from']) && isset($value['to'])) {
                    $query->whereBetween('created_at', [
                        $value['from'] . ' 00:00:00',
                        $value['to']   . ' 23:59:59'
                    ]);
                } elseif (isset($value['from'])) {
                    $query->where('created_at', '>=', $value['from'] . ' 00:00:00');
                } elseif (isset($value['to'])) {
                    $query->where('created_at', '<=', $value['to'] . ' 23:59:59');
                }
            }),
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
        return [
            'id',
            'log_name',
            'description',
            'subject_type',
            'subject_id',
            'causer_id',
            'properties',
            'created_at',
            'updated_at'
        ];
    }
}
