<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  protected $fillable = [
    'name'
  ];

  public function user(){
    return $this->belongsToMany('App\User');
  }

  public function tasks(){
    return $this->hasMany('App\Task');
  }
}
