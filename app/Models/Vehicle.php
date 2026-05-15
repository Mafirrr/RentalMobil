<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vehicle extends Model
{
    protected $fillable = [
        'category_id',
        'vehicle_type',
        'model',
        'plate_number',
        'year',
        'color',
        'daily_rate',
        'status'
    ];

    // Relasi ke kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relasi ke detail mobil
    public function car(): HasOne
    {
        return $this->hasOne(Car::class, 'vehicle_id');
    }

    // Relasi ke detail motor
    public function motorcycle(): HasOne
    {
        return $this->hasOne(Motorcycle::class, 'vehicle_id');
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    // Helper untuk mengambil detail siapapun tipenya
    public function getDetailsAttribute()
    {
        return $this->vehicle_type === 'car'
            ? $this->carDetail
            : $this->motorcycleDetail;
    }
}
