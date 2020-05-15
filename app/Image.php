<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  protected $fillable = [
    'file_name', 'user_id', 'group_id'
  ];
}
