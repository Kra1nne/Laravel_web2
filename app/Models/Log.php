<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
  protected $table = 'logs';

  protected $fillable = [
    'id',
    'action',
    'table_name',
    'description',
    'ip_address',
    'created_at',
    'user_id'
  ];
}
