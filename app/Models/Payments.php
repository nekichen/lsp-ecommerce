<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_id',
        'amount',
        'payment_date',
        'payment_method',
        'account_number',
        'payment_status',
    ];

    public function setPaymentStatusAttribute($value)
    {
        // Ensure that the value is one of the allowed statuses
        $allowedStatuses = ['not paid', 'paid', 'cancelled'];
        
        // If the payment method is 'cod', set the status to 'not paid'
        if ($this->payment_method === 'cod') {
            $this->attributes['payment_status'] = 'not paid';
        }
        // For other payment methods, set the status to 'paid'
        else {
            $this->attributes['payment_status'] = 'paid';
        }
    }
}
