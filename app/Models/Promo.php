<?php

namespace App\Models;

use App\Models\Facility;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
  protected $table = "promos";

  protected $fillable = [
    "facilities_id",
    "id",
    "name",
    "description",
    "max_person",
    "additional_price",
    "price",
    "created_at",
    "updated_at",
    "deleted_at"
  ];

  public function facility()
  {
      return $this->belongsTo(Facility::class, 'facilities_id');
  }
}
