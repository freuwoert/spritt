<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drive extends Model
{
    use HasFactory;

    protected $appends = array('consumption', 'total_passengers');

    protected $fillable = [
        'car_id',
        'distance',
        'started_at',
        'paid',
    ];

    protected $casts = [
        'distance' => 'float',
        'started_at' => 'datetime',
        'paid' => 'boolean',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function passengers()
    {
        return $this->belongsToMany(Passenger::class);
    }

    public function getConsumptionAttribute()
    {
        if (!$this->car) return 0;
        return $this->car->consumption / 100 * $this->distance;
    }

    public function getTotalPassengersAttribute()
    {
        return $this->passengers->count();
    }
}
