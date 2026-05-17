<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rental extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Atribut yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'user_id',
        'merchant_ref',
        'NIK',
        'vehicle_id',
        'rental_date',
        'return_date_scheduled',
        'duration',
        'pickup_location',
        'deliver_to_location',
        'total_price',
        'amount_paid',
        'status',
    ];

    /**
     * Casting tipe data kolom.
     */
    protected $casts = [
        'rental_date' => 'datetime',
        'return_date_scheduled' => 'datetime',
        'duration' => 'integer',
        'total_price' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    /**
     * Relasi ke User (Penyewa).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Car (Mobil yang disewa).
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    /**
     * Relasi ke ReturnCar (Data pengembalian).
     * Menghubungkan transaksi rental dengan data saat mobil dikembalikan.
     */
    public function returnCar(): HasOne
    {
        return $this->hasOne(ReturnCar::class, 'rental_id');
    }

    public function rating(): HasOne
    {
        return $this->hasOne(Rating::class, 'rental_id');
    }
}
