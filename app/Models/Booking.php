<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = ['id'];

    public function trip() { return $this->belongsTo(Trip::class)->withTrashed(); }
    public function user() { return $this->belongsTo(User::class); }
    public function passengers() { return $this->hasMany(Passenger::class); }
}
