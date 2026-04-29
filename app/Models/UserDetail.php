<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
        'identity_number'
    ];

    public function user(): BelongsTo
    {
        // Relasi balik ke model User
        return $this->belongsTo(User::class, 'user_id');
    }
}
