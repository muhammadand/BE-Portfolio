<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Vendor extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
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
    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }
}
