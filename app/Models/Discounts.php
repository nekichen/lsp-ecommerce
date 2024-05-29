<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'max_use',
        'max_user',
        'type',
        'amount',
        'min_amount',
        'is_active',
        'start_date',
        'end_date',
    ];
}
