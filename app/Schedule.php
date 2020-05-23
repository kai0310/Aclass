<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
  protected $fillable = ['name', 'discription', 'time'];

  public function groups(){
    return $this->belongsToMany('App\Group');
  }
}
