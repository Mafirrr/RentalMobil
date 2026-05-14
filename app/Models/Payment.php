<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Atribut yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'reference',
        'merchant_ref',
        'rental_id',
        'total_bill',
        'amount',
        'fee_amount',
        'net_amount',
        'payment_method',
        'payment_type',
        'payment_name',
        'status',
        'checkout_url',
        'paid_at'
    ];

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }
}
