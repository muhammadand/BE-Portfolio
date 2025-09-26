<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasActivityLogs;

class Permission extends Model
{
    use HasFactory;
    use HasActivityLogs;

    protected $fillable = [
        'name',
        'slug',
    ];

    // 🔑 Relasi Many-to-Many: Permission bisa dipunya banyak Role
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}
