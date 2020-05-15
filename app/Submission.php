<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{

  protected $fillable = [
    'title', 'body', 'user_id', 'task_id'
  ];
}
