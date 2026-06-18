<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    public $timestamps = false; // we only use created_at via database timestamp defaults
    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected $fillable = ['product_variant_id', 'quantity_change', 'type', 'log_message'];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
