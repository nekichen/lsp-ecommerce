<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'user_id',
        'phone',
        'country_id',
        'city',
        'address',
        'apartment',
        'zip_code'
    ];

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }
}
