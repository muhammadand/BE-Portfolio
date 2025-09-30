<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Permission extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Konfigurasi Activity Log versi Spatie v5+
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()      // otomatis log semua field fillable
            ->logOnlyDirty()     // hanya log kalau ada perubahan
            ->useLogName('permission'); // nama log
    }

    /**
     * Pesan custom untuk setiap event
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Permission has been {$eventName}";
    }

    /**
     * Relasi Many-to-Many: Permission bisa dipunya banyak Role
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}
