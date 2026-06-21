<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbandonedCart extends Model
{
    protected $fillable = [
        'user_id', 'session_token', 'name', 'phone', 'email', 
        'shipping_address', 'shipping_city', 'shipping_pincode', 
        'shipping_landmark', 'cart_data', 'status', 'last_activity_at'
    ];

    protected $casts = [
        'cart_data' => 'array',
        'last_activity_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
