<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\Blameable;

class Vendor extends Model
{
    use HasFactory, LogsActivity, SoftDeletes,Blameable;

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Konfigurasi kolom tanggal
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * Konfigurasi Activity Log (Spatie v5+)
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()           // log semua field fillable
            ->logOnlyDirty()          // log hanya perubahan
            ->useLogName('vendor');   // pakai nama log "vendor"
    }

    /**
     * Pesan custom untuk setiap event
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Vendor has been {$eventName}";
    }

    /**
     * Relasi: Vendor punya banyak Product
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }

    /**
     * Events untuk mengisi created_by, updated_by, deleted_by
     */
    
    
}
