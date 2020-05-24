<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Group;
use App\User;

class GroupController extends Controller
{
  public function new(Request $request){
    $validated = $request->validate([
      'name' => "string|required|max:100"
    ]);
    $group = Group::create([
      'name' => encryptData($validated['name'], 'DATA_KEY')
    ]);
    return redirect(route('groupSingle', ['group' => $group->id]));
  }

  public function single(Group $group){
    return view('pages.teachers.groups.single', ['group' => $group]);
  }

  public function newUser($group_id, Request $request){
    $validated = $request->validate([
      'userId' => 'required|array',
      'userId.*' => 'numeric|required'
    ]);
    foreach($validated['userId'] as $user){
      if(User::where('id', $user)->exists()){
        User::find($user)->group()->detach($group_id);
        User::find($user)->group()->attach($group_id);
      }
    }
    return redirect(route('groupSingle', ['group' => $group_id]));
  }

  public function deleteUser($group_id, Request $request){
    $validated = $request->validate([
      'userId' => 'required|numeric'
    ]);
    if(User::where('id', $validated['userId'])->exists()){
      User::find($validated['userId'])->group()->detach($group_id);
    }
    return redirect(route('groupSingle', ['group' => $group_id]));
  }

  public function delete(Request $request){
    dd($request);
  }

  public function all(){
    return view('pages.teachers.groups.all', ['groups' => Group::get()]);
  }
}
