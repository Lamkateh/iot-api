<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'period',
        'start',
        'end',
    ];

    public function measures(): HasMany
    {
        return $this->hasMany(Measure::class);
    }
}
