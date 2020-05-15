<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
  protected $fillable = [
    'body', 'user_id', 'post_id'
  ];
}
