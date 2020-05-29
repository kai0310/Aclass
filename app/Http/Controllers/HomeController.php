<?php

namespace App\Http\Controllers;

use App\Submission;
use DateTime;
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
        $taskIds = [];
        $taskCount = 0;
        foreach ($fiveDaysTasks as $fiveDaysTask){
            $taskIds[]=$fiveDaysTask["id"];
            $limit= new DateTime($fiveDaysTask['limit']);
            $diff = $limit->diff(new DateTime('now'));
            $dateDiff = $diff->d;
            if($dateDiff<1){
                $fiveDaysTasks[$taskCount]['limit'] = "今日の".date('H時i分', strtotime($fiveDaysTask['limit']));
            }else if($dateDiff<2){
                $fiveDaysTasks[$taskCount]['limit'] = "明日の".date('H時i分', strtotime($fiveDaysTask['limit']));
            }else{
                $fiveDaysTasks[$taskCount]['limit'] = date('n月d日H時i分', strtotime($fiveDaysTask['limit']));
            }
            $taskCount++;
        }
        $finishTasksId = Submission::where('user_id',Auth::id())->whereIn('task_id',$taskIds)->pluck('id','task_id');
        return view('pages.home', ['schedules' => $schedules,'tasks'=>$fiveDaysTasks,'finishTasksId'=>$finishTasksId]);
    }
}
