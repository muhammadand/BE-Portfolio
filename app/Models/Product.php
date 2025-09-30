<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Product extends Model
{
   
    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'vendor_id',
        'vendor_sku',
        'price',
        'description',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
