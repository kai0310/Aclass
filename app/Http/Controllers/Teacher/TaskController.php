<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Group;
use App\Task;
use App\Submission;
use App\File;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
  public function form(){
    return view('pages.teachers.task.new', [
      'groups' => Group::get()
    ]);
  }

  public function new(Request $request){

    $validated = $request->validate([
      'title' => "string|required|max:100",
      'body' => "string|required|max:5000",
      'limit' => "date|nullable",
      'groups' => "required",
      'groups.*' => "string|exists:groups,id"
    ]);

    foreach($validated['groups'] as $group){

      $task = Task::create([
        'title' => encryptData($validated['title'], 'DATA_KEY'),
        'body' => encryptData($validated['body'], 'DATA_KEY'),
        'group_id' => $group,
        'user_id' => Auth::id(),
        'limit' => $validated['limit']
      ]);

      if($request->file('files')!==NULL){
        foreach($request->file('files') as $file){
          File::create([
            'origin_name' => $file->getClientOriginalName(),
            'file_name' => $file->store('private'),
            'user_id' => Auth::id(),
            'task_id' => $task->id
          ]);
        }
      }

    }

    return redirect(route('tasks'));
  }

  public function all(){
    return view('pages.teachers.task.all', ['tasks' => Task::orderBy('id', 'desc')->with(['user', 'submissions', 'group'])->get()]);
  }

  public function submissionAll(Task $task){
    return view('pages.teachers.task.submission.all', ['task' => $task]);
  }

  public function submission(Task $task,Submission $submission){
    return view('pages.teachers.task.submission.single', ['task' => $task, 'submission' => $submission]);
  }
}
