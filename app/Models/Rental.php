<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rental extends Model
{
    protected $fillable = [
        'user_id',
        'car_id',
        'rental_date',
        'return_date_scheduled',
        'return_date_actual',
        'total_price',
        'status'
    ];

    protected $casts = [
        'rental_date' => 'datetime',
        'return_date_scheduled' => 'datetime',
        'return_date_actual' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
