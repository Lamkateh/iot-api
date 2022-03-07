<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Measure extends Model
{
    use HasFactory;

    protected $casts = [
        'values' => 'array',
    ];

    protected $fillable = [
        'values',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
