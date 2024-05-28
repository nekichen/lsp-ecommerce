<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Products;

class ProductImages extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'image',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            // Logging untuk debugging
            \Log::info('Deleting image from storage: ' . $image->image);
            // Menghapus gambar dari storage
            Storage::delete($image->image);
        });
    }
}
