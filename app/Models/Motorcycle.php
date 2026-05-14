<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Motorcycle extends Model
{
    protected $fillable = [
        'vehicle_id',
        'capacity',
        'transmission',
        'fuel_type'
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
