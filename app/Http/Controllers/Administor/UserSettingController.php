<?php

namespace App\Http\Controllers\Administor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Level;

class UserSettingController extends Controller
{
  public function userSingle(Request $request){
    $request->validate([
      'data'=> 'numeric|exists:users,id'
    ]);

    $levels = [];
    foreach(Level::get(['id', 'name']) as $level){
      $levels[] = [
        'id' => $level['id'],
        'name' => decryptData($level['name'], 'DATA_KEY')
      ];
    }

    $responseData = [
      'user_id' => $request->input('data'),
      'name' => decryptData(User::find($request->input('data'))['name'], 'USER_KEY'),
      'level' => decryptData(User::find($request->input('data'))->level['name'], 'DATA_KEY'),
      'level_id' => User::find($request->input('data'))->level['id'],
      'levels' => $levels
    ];
    return $responseData;
  }

  public function change(Request $request){
    $request->validate([
      'user_id' => 'numeric|required|exists:users,id',
      'level_id' => 'numeric|required|exists:levels,id',
      'name' => 'required|string'
    ]);

    $user = User::find($request->input('user_id'));
    $user->level_id = $request->input('level_id');
    $user->name = encryptData($request->input('name'), 'USER_KEY');
    $user->save();

    return redirect()->back();
  }
}
