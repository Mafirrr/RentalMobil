<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name'];

    public function vehicle(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'category_id');
    }
}
