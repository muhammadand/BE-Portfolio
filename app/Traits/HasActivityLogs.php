<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait HasActivityLogs
{
    public static function bootHasActivityLogs()
    {
        // Saat CREATE
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

        // Saat UPDATE
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });

        // Saat DELETE (soft delete)
        static::deleting(function ($model) {
            if (Auth::check() && $model->usesSoftDeletes()) {
                $model->deleted_by = Auth::id();
                $model->saveQuietly();
            }
        });

        // Logging Activity
        foreach (['created', 'updated', 'deleted'] as $event) {
            static::$event(function ($model) use ($event) {
                ActivityLog::create([
                    'causer_id'   => Auth::id(),
                    'log_name'    => class_basename($model),
                    'description' => ucfirst($event) . ' ' . class_basename($model),
                    'subject_type'=> get_class($model),
                    'subject_id'  => $model->id,
                    'properties'  => $model->toArray(),
                    'created_at'  => now(),
                ]);
            });
        }
    }

    /**
     * Helper untuk cek apakah model pakai SoftDeletes
     */
    protected function usesSoftDeletes(): bool
    {
        return in_array('Illuminate\\Database\\Eloquent\\SoftDeletes', class_uses_recursive(static::class));
    }
}
