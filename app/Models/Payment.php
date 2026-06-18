<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id', 'payment_method', 'transaction_reference', 'amount', 'status', 'payload'];

    protected $casts = [
        'payload' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
