<?php

namespace App\Models;

use App\Models\Person;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements MustVerifyEmail
{
  use Notifiable;
  protected $table = 'users';
  protected $fillable = [
    'id',
    'email',
    'password',
    'role',
    'created_at',
    'updated_at',
    'deleted_at',
    'person_id',
    'email_verified_at',
  ];
  public function person()
  {
    return $this->belongsTo(Person::class, 'person_id');
  }
}
