<?php

namespace App\Http\Controllers;

use App\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Schedule;
use App\User;
use App\Task;

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
        $allGroupId = [];
        foreach(Auth::user()->group as $group){
            foreach($group->schedules as $schedule){
                $allGroupSchedules[] = $schedule['id'];
            }
            $allGroupId[]= $group->id;
        }
        $thirtyDaysGroupSchedules = [];
        foreach($thirtyDaysSchedules as $schedule){
            if(in_array($schedule, $allGroupSchedules)){
                $thirtyDaysGroupSchedules[] = $schedule;
            }
        }
        $schedules = Schedule::whereIn('id', $thirtyDaysGroupSchedules)->with(['groups'])->get();
        $fiveDaysTasks = Task::whereDate('limit', '>=', date("Y-m-d"))->whereDate('limit', '<=', date("Y-m-d",strtotime("+5 day")))->whereIn('group_id',$allGroupId)->orderBy('limit', 'asc')->get();
        return view('pages.home', ['schedules' => $schedules,'tasks'=>$fiveDaysTasks]);
    }
}
