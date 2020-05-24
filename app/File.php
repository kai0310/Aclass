<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
  protected $fillable = [
    'file_name', 'origin_name', 'user_id', 'task_id', 'submission_id', 'post_id'
  ];
}
