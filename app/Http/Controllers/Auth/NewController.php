<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class NewController extends Controller
{
  public function new(Request $request){

    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'hash_login_id' => ['required', 'numeric'],
      'password' => ['required', 'string', 'min:8', 'confirmed']
    ]);

    $count = User::where('hash_login_id', hash('sha256', $request->hash_login_id))->where('temporary', true)->count();
    if($count > 1){
      abort(500);
    }

    $requestUserData = User::where('hash_login_id', hash('sha256', $request->hash_login_id))->where('temporary', true)->first();
    if(isset($requestUserData) && decryptData($requestUserData['name'], 'USER_KEY') === $request->name && $count === 1){
      $user = User::where('hash_login_id', hash('sha256', $request->hash_login_id))->first();
      $user->password = Hash::make($request->password);
      $user->temporary = false;
      $user->save();

      $credentials = [
        'hash_login_id' => hash('sha256', $request->hash_login_id),
        'password' => $request->password
      ];

      return redirect('login')->with([
        'result' => 'success',
        'message' => '登録に成功しました。ログインしてください。'
      ]);
    }else{
      return redirect()->back()->with([
        'result' => 'failed',
        'message' => '該当するユーザーは見つかりませんでした。'
      ]);
    }
  }
}
