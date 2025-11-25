<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'person';

    protected $fillable = [
      'id',
      'firstname',
      'middlename',
      'lastname',
      'address',
      'phone_number',
      'created_at',
      'updated_at',
      'deleted_at'
    ];
}
