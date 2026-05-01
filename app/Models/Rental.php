<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rental extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_address',
        'car_id',
        'rental_date',
        'return_date_scheduled',
        'return_date_actual',
        'total_price',
        'amount_paid',
        'status',
        'admin_notes'
    ];

    protected $casts = [
        'rental_date' => 'datetime',
        'return_date_scheduled' => 'datetime',
        'return_date_actual' => 'datetime',
        'total_price' => 'decimal:2',
        'amount_paid' => 'decimal:2'
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
