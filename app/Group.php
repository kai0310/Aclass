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

  public function schedules(){
    return $this->belongsToMany('App\Schedule');
  }

  public function posts(){
    return $this->hasMany('App\Post')->orderBy('id', 'desc');
  }
}
