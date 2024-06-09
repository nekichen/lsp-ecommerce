<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductImages;
use App\Models\Categories;
use App\Models\Brands;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'sku',
        'price',
        'stock',
        'brand_id',
        'category_id',
        'slug',
        'active'
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ProductImages::class,'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            foreach ($product->images as $image) {
                // Logging untuk debugging
                \Log::info('Deleting associated image from storage: ' . $image->image);
                // Menghapus gambar dari storage
                Storage::delete($image->image);
                $image->delete();
            }
        });
    }

    public function reviews()
    {
        return $this->hasMany(ProductReviews::class, 'product_id');
    }
}
