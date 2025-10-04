<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait Blameable
{
    public static function bootBlameable()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = self::makeUserInfo();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = self::makeUserInfo();
            }
        });

        static::deleting(function ($model) {
            if (Auth::check()) {
                $model->deleted_by = self::makeUserInfo();
                $model->saveQuietly(); // biar gak trigger update lagi
            }
        });
    }

    protected static function makeUserInfo(): array
    {
        $user = Auth::user();
        return [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
        ];
    }

    /**
     * Tambahkan casts otomatis biar JSON bisa jadi array
     */
    public function initializeBlameable()
    {
        $this->casts['created_by'] = 'array';
        $this->casts['updated_by'] = 'array';
        $this->casts['deleted_by'] = 'array';
    }
}
