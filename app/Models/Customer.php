<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\Blameable;

class Customer extends Model
{
    use HasFactory, LogsActivity, SoftDeletes, Blameable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'channel_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Log activity settings (Spatie Activity Log)
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('customer');
    }

    /**
     * Description for activity events
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Customer has been {$eventName}";
    }

    /**
     * Relationship to Enumeration (for channel)
     */
    public function channel()
    {
        return $this->belongsTo(Enumeration::class, 'channel_id');
    }
}
