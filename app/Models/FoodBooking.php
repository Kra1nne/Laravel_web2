<?php

namespace App\Models;

use App\Models\Food;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;

class FoodBooking extends Model
{
    protected $table = 'food_bookings';

    protected $fillable = [
        'id',
        'bookings_id',
        'foods_id',
        'quantity',
        'created_at',
        'updated_at',
    ];

    public function bookings()
    {
      return $this->belongsTo(Booking::class, 'bookings_id');
    }
    public function foods()
    {
      return $this->belongsTo(Food::class, 'foods_id');
    }
}
