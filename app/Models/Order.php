<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'status', 'subtotal', 'discount', 
        'delivery_charge', 'grand_total', 'payment_method', 'payment_status', 
        'shipping_name', 'shipping_phone', 'shipping_alt_phone', 
        'shipping_address', 'shipping_pincode', 'shipping_city', 
        'shipping_landmark', 'order_notes',
        'tracking_number', 'carrier_name', 'shipped_at', 'delivered_at'
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function returns()
    {
        return $this->hasMany(ReturnRequest::class); // returned items
    }
}
