<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth; // ✅ penting
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\Blameable;

class ProductCategory extends Model
{
    use SoftDeletes, LogsActivity,Blameable;

    protected $table = 'product_categories';

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Event hooks untuk set created_by, updated_by, deleted_by
     */
    
    /**
     * Konfigurasi Activity Log versi Spatie v5+
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('product_category');
    }

    /**
     * Pesan custom untuk setiap event
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Product category has been {$eventName}";
    }

    /**
     * Relasi
     */
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
