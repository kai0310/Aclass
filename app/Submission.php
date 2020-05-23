<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{

  protected $fillable = [
    'title', 'body', 'user_id', 'task_id'
  ];

  public function user(){
    return $this->belongsTo('App\User');
  }

  public function files(){
    return $this->hasMany('App\File');
  }

  public function task(){
    return $this->belongsTo('App\Task');
  }
}
