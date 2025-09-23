<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    public $timestamps = false; // hanya ada created_at

    protected $fillable = [
        'causer_id',
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'properties',
        'created_at'
    ];

    public function causer()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

    // Polymorphic untuk subject (Product, Vendor, Category, dll)
    public function subject()
    {
        return $this->morphTo(null, 'subject_type', 'subject_id');
    }
}
