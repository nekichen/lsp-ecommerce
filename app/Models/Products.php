<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        return $this->hasMany(ProductImages::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
    }
}
