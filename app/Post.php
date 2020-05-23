<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  protected $fillable = [
    'title', 'body', 'user_id', 'group_id'
  ];

  public function user(){
    return $this->belongsTo('App\User');
  }

  public function files(){
    return $this->hasMany('App\File');
  }

  public function group(){
    return $this->belongsTo('App\Group');
  }
}
