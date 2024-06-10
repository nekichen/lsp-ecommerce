<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliveries extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'shipped_date',
        'delivered_date',
        'tracking_code',
        'status'
    ];
}
