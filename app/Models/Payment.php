<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  protected $table = 'payments';

  protected $fillable = [
    'id',
    'card',
    'status',
    'amount',
    'payment_code',
    'discount',
    'created_at',
    'bookings_id',
    'payment_id',
  ];
  public function booking()
  {
      return $this->belongsTo(Booking::class, 'booking_id', 'id');
  }

}
