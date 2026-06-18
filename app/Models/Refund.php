<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = ['return_id', 'payment_id', 'amount', 'status', 'transaction_reference'];

    public function returnRequest()
    {
        return $this->belongsTo(ReturnRequest::class, 'return_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
