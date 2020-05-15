<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwoFactor extends Model
{
  protected $fillable = [
    'user_id', 'key'
  ];
}
