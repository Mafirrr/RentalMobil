<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnCar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'return_cars';

    protected $fillable = [
        'rental_id',
        'return_date',
        'car_condition',
        'payment_penalty',
        'admin_notes',
    ];

    /**
     * Casting tipe data kolom.
     */
    protected $casts = [
        'return_date' => 'datetime',
        'payment_penalty' => 'decimal:2',
    ];

    /**
     * Relasi ke model Rental.
     * Menunjukkan bahwa setiap data pengembalian dimiliki oleh satu transaksi rental.
     */
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }
}
