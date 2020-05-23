<?php

namespace App\Http\Controllers\Administor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Group;
use App\User;
use App\Level;

class LevelController extends Controller{
  public function changeForm(){
    return view('pages.administors.levels.change', [
      'users' => User::with('level')->get(),
      'levels' => Level::get()
    ]);
  }

  public function change(Request $request){
    dd($request);
    $validated = $request->validate([
      'user_id' => 'exists:users,id|numeric|required'
    ]);


    $user = User::find($validated['userId']);
    $user->level = $validated['level'];
    $user->save();

    return redirect()->back()->with(['changeUserLevel' => '変更が完了しました。']);
  }
}
