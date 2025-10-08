<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\Blameable;

class Enumeration extends Model
{
    use HasFactory, LogsActivity, SoftDeletes, Blameable;

    protected $fillable = [
        'label',
        'name',
        'value',
        'group',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Spatie Activity Log options
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('enumeration');
    }

    /**
     * Description for activity events
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Enumeration has been {$eventName}";
    }

    /**
     * Relationship to customers (for channel or reference)
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'channel_id');
    }
}
