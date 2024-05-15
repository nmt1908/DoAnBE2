<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Product extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'product_name',
        'price',
        'description',
        'quantity',
        'is_featured',
        'category_id',
        'brand_id',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }
    public function image()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
