<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  protected $fillable = [
    'title', 'body', 'user_id', 'group_id', 'limit', 'twofactor'
  ];

  public function group(){
    return $this->belongsTo('App\Group');
  }

  public function user(){
    return $this->belongsTo('App\User');
  }

  public function submissions(){
    return $this->hasMany('App\Submission');
  }

  public function files(){
    return $this->hasMany('App\File');
  }
}
