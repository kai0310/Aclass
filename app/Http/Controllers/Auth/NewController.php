<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class NewController extends Controller
{
  public function new(Request $request){

    $request->validate([
      'hash_login_id' => ['required', 'numeric'],
      'temporary_password' => ['required', 'numeric'],
      'password' => ['required', 'string', 'min:8', 'confirmed']
    ]);

    $count = User::where('hash_login_id', hash('sha256', $request->hash_login_id))->where('temporary', true)->count();
    if($count > 1){
      abort(500);
    }

    $requestUserData = User::where('hash_login_id', hash('sha256', $request->hash_login_id))->where('temporary', true)->first();
    if(isset($requestUserData) && decryptData($requestUserData['temporary_password'], 'TEMP_KEY') == $request->temporary_password && $count === 1){
      $user = User::where('hash_login_id', hash('sha256', $request->hash_login_id))->first();
      $user->password = Hash::make($request->password);
      $user->temporary = false;
      $user->temporary_password = NULL;
      $user->save();

      $credentials = [
        'hash_login_id' => hash('sha256', $request->hash_login_id),
        'password' => $request->password
      ];

      if(Auth::attempt($credentials)){
        return redirect()->route('welcome');
      }
    }

    return redirect()->back()->with([
      'result' => 'failed',
      'message' => '該当するユーザーは見つかりませんでした。'
    ]);

  }
}
