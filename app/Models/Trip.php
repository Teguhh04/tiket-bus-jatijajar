<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'operator_id',
        'origin_id',
        'destination_id',
        'departure_time',
        'arrival_time',
        'duration',
        'price',
        'bus_class',
        'available_seats',
        'facilities',
        'image'
    ];

    protected $casts = [
        'facilities' => 'array',
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
    ];

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function origin()
    {
        return $this->belongsTo(Terminal::class, 'origin_id');
    }

    public function destination()
    {
        return $this->belongsTo(Terminal::class, 'destination_id');
    }
}