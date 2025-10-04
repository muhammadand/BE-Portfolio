<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['name', 'slug'];

    protected static function booted()
    {
        static::saving(function ($role) {
            // Bikin slug dari name
            $baseSlug = Str::slug($role->name, '_');
            $slug = $baseSlug;

            // Cek apakah slug sudah dipakai oleh role lain
            $count = 1;
            while (Role::where('slug', $slug)
                      ->where('id', '!=', $role->id) // biar update tidak bentrok dengan dirinya sendiri
                      ->exists()) {
                $slug = $baseSlug . '_' . $count;
                $count++;
            }

            $role->slug = $slug;
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('role');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Role has been {$eventName}";
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}

