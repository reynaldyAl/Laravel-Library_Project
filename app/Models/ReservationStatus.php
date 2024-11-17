<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationStatus extends Model
{
    protected $fillable = [
        'status_name',
        'description'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
