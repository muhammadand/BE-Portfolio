<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

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
