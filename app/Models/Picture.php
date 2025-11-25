<?php

namespace App\Models;

use App\Models\Food;
use App\Models\Facility;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $table = 'pictures';

    protected $fillable = [
      'id',
      'path',
      'facilities_id',
      'foods_id',
      'created_at',
      'updated_at',
      'deleted_at'
    ];
    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facilities_id');
    }
    public function food()
    {
        return $this->belongsTo(Food::class, 'foods_id');
    }
}
