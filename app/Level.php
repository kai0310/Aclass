<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
  protected $fillable = [
    'name', 'teacher', 'administor'
  ];

  public function users(){
    return $this->hasMany('App\User');
  }
}
