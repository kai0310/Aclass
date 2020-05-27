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
    $validated = $request->validate([
      'user_id' => 'exists:users,id|numeric|required',
      'level_id' => 'exists:levels,id|numeric|required',
    ]);

    $user = User::find($validated['user_id']);
    $user->level_id = $validated['level_id'];
    $user->save();

    return redirect()->back()->with(['result' => 'success', 'message' => 'レベルの変更に成功しました。']);
  }
}
