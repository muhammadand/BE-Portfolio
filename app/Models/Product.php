<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Product extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'vendor_id',
        'vendor_sku',
        'price',
        'description',
        'is_active',
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
            ->useLogName('product');  // pakai nama log "product"
    }

    /**
     * Pesan custom untuk setiap event
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Product has been {$eventName}";
    }

    /**
     * Relasi: Product punya kategori dan vendor
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    /**
     * Events untuk mengisi created_by, updated_by, deleted_by
     */
    protected static function booted()
    {
        static::creating(function ($product) {
            if (Auth::check()) {
                $product->created_by = Auth::id();

            }
        });

        static::updating(function ($product) {
            if (Auth::check()) {
                $product->updated_by = Auth::id();
            }
        });

        static::deleting(function ($product) {
            if (Auth::check()) {
                $product->deleted_by = Auth::id();
                $product->saveQuietly(); // supaya ga trigger event update lagi
            }
        });
    }
}
