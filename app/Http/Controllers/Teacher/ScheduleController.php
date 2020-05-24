<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Group;
use App\Schedule;

class ScheduleController extends Controller
{
  public function form(){
    return view('pages.teachers.schedule.new', [ 'groups' => Group::get() ]);
  }

  public function new(Request $request){

    $validated = $request->validate([
      'name' => "string|required|max:100",
      'description' => "string|required|max:5000",
      'time' => "date|required",
      'groups' => "required",
      'groups.*' => "string|exists:groups,id"
    ]);

    $schedule = Schedule::create([
      'name' => encryptData($validated['name'], 'DATA_KEY'),
      'description' => encryptData($validated['description'], 'DATA_KEY'),
      'time' => $validated['time']
    ]);

    foreach($validated['groups'] as $group){
      $schedule->groups()->attach($group);
    }

    return redirect(route('home'));
  }
}
