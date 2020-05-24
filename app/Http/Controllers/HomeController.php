<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Schedule;
use App\User;

class HomeController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Contracts\Support\Renderable
  */
  public function index()
  {
    $thirtyDaysSchedules = Schedule::whereDate('time', '>=', date("Y-m-d"))->whereDate('time', '<=', date("Y-m-d",strtotime("+30 day")))->orderBy('time', 'asc')->pluck('id');
    $allGroupSchedules = [];
    foreach(Auth::user()->group as $group){
      foreach($group->schedules as $schedule){
        $allGroupSchedules[] = $schedule['id'];
      }
    }
    $thirtyDaysGroupSchedules = [];
    foreach($thirtyDaysSchedules as $schedule){
      if(in_array($schedule, $allGroupSchedules)){
        $thirtyDaysGroupSchedules[] = $schedule;
      }
    }
    $schedules = Schedule::whereIn('id', $thirtyDaysGroupSchedules)->with(['groups'])->get();
    return view('pages.home', ['schedules' => $schedules]);
  }
}
