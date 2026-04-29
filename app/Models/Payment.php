<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'rental_id',
        'payment_date',
        'amount',
        'payment_method',
        'payment_status'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }
}
