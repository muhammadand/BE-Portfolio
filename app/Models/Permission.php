<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

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
