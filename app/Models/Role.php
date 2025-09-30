<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Role extends Model
{
    use HasFactory;
    use LogsActivity;

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
            ->logFillable()          // otomatis log semua field fillable
            ->logOnlyDirty()         // hanya log jika ada perubahan
            ->useLogName('role');    // nama log khusus untuk role
    }

    /**
     * Pesan custom untuk setiap event
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Role has been {$eventName}";
    }

    // 🔑 Relasi Many-to-Many: Role bisa dimiliki banyak User
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role');
    }

    // 🔑 Relasi Many-to-Many: Role punya banyak Permission
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}
