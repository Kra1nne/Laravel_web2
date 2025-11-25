<?php

namespace App\Models;

use App\Models\Picture;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

    protected $fillable = [
        'id',
        'name',
        'price',
        'category',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'users_id',
    ];

    public function picture()
    {
        return $this->hasMany(Picture::class, 'foods_id');
    }
    public function booking()
    {
      return $this->belongsToMany(Booking::class, 'food_bookings', 'bookings_id', 'foods_id');
    }
}
