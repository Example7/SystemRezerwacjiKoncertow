<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['price', 'reservation_id'];

    public function concert()
    {
        return $this->belongsTo(Concert::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
