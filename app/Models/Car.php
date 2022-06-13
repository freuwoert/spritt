<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'consumption',
        'fuel_type',
    ];

    protected $casts = [
        'consumption' => 'float',
    ];

    public function drives()
    {
        return $this->belongsToMany(Drive::class);
    }
}
