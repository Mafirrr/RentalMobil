<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'rental_id', // Nama kolom sesuai migrasi Anda
        'rating',
        'comment',
    ];

    /**
     * Relasi ke model Rental.
     * Karena nama kolom foreign key Anda 'rentals',
     * kita harus mendefinisikannya secara eksplisit di parameter kedua.
     */
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class, 'rentals');
    }
}
