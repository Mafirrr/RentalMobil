<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'address',
        'avatar_path',
        'license_number',
        'license_type',
        'license_expired',
        'license_image_path',
        'status',
        'is_active',
    ];

    /**
     * Konversi tipe data otomatis (Casting).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'license_expired' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Query supir yang statusnya siap bertugas dan akunnya aktif.
     * Contoh penggunaan: Driver::available()->get();
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'available')
            ->where('is_active', true);
    }

    /**
     * Query supir yang lisensi / SIM-nya masih berlaku (belum kedaluwarsa).
     * Contoh penggunaan: Driver::validLicense()->get();
     */
    public function scopeValidLicense(Builder $query): Builder
    {
        return $query->where('license_expired', '>', now());
    }

    /**
     * Accessor untuk mendapatkan URL penuh dari avatar supir.
     * Jika tidak ada avatar, mengembalikan gambar default.
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar_path
            ? asset('storage/' . $this->avatar_path)
            : asset('images/default-avatar.png');
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class, 'driver_id');
    }
}
