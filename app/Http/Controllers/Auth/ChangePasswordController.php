<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
  public function index(Request $request){
    if(!(Hash::check($request->get('nowPassword'), Auth::user()['password']))) {
      return redirect()->back()->with(['result' => 'failed', 'message' => '現在のパスワードが間違っています。']);
    }

    $validated = $request->validate([
      'nowPassword' => 'required',
      'newPassword' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();
    $user->password = Hash::make($validated['newPassword']);
    $user->save();
    return redirect()->back()->with(['result' => 'success', 'message' => '変更が完了しました。']);
  }
}
