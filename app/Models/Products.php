<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ProductImages;

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
}
