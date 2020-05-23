<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use App\Task;
use App\Submission;
use App\File;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
  public function index(){
    return view('pages.tasks.index', [
      'user' => User::where('id', Auth::id())->with('group.tasks')->first()
    ]);
  }

  public function single($task_id){
    if(Task::where('id', $task_id)->doesntExist()){
      abort(404);
    }else{
      if(Auth::user()->group()->find(Task::find($task_id)['group_id']) !== NULL){
        return view('pages.tasks.single', [
          'task' => Task::where('id', $task_id)->with('user', 'group', 'files')->first()
        ]);
      }else{
        abort(404);
      }
    }
  }

  public function newSubmission($task_id, Request $request){
    $validated = $request->validate([
      'body' => 'string|required',
    ]);
    if(Task::where('id', $task_id)->doesntExist()){
      abort(404);
    }else{
      if( isset(Task::find($task_id)['limit']) && strtotime(Task::find($task_id)['limit']) < strtotime(date('Y/m/d H:i:s')) ){
        return redirect()->back()->with(['message' => '提出期限が過ぎています。', 'result' => 'failed']);
      }
      if(Auth::user()->group()->find(Task::find($task_id)['group_id']) !== NULL){
        $submission = Submission::create([
          'body' => encryptData($validated['body'], 'DATA_KEY'),
          'task_id' => $task_id,
          'user_id' => Auth::id()
        ]);

        if($request->file('files')!==NULL){
          foreach($request->file('files') as $file){
            File::create([
              'origin_name' => $file->getClientOriginalName(),
              'file_name' => $file->store('private'),
              'user_id' => Auth::id(),
              'submission_id' => $submission->id
            ]);
          }
        }
        return redirect()->back()->with(['message' => '送信に完了しました。', 'result' => 'success']);
      }else{
        abort(404);
      }
    }
  }

  public function submissionAll(){
    return view('pages.tasks.submissions.all', ['submissions' => Auth::user()->submissions]);
  }

  public function submissionSingle($submission_id){
    if(Submission::where('id', $submission_id)->doesntExist()){
      abort(404);
    }else{
      if(Submission::find($submission_id)['user_id']!==Auth::id()){
        abort(404);
      }
      return view('pages.tasks.submissions.single', ['submission' => Submission::find($submission_id)]);
    }
  }
}
