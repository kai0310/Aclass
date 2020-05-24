<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\File;
use App\Task;
use App\Post;
use App\Submission;

class FileController extends Controller
{
  public function index($file_name){
    if(File::where('file_name', $file_name)->exists()){ // 画像の存在確認

      $taskId = File::where('file_name', $file_name)->first()['task_id']; // 画像を使用できるTaskのID取得
      $postId = File::where('file_name', $file_name)->first()['post_id']; // 画像を使用できるPostのID取得
      $submissionId = File::where('file_name', $file_name)->first()['submission_id']; // 画像を使用できるSubmissionのID取得

      $existTask = Task::find($taskId); // Taskの存在確認
      $existPost = Post::find($postId); // Postの存在確認
      $existSubmission = Submission::find($submissionId); // Submissionの存在確認
      
      if(
         ( isset($taskId) && isset($existTask) && Task::find($taskId)->group->user->find(Auth::id()) !== NULL ) ||
         ( isset($postId) && isset($existPost) && Post::find($postId)->group->user->find(Auth::id()) !== NULL ) ||
         ( isset($submissionId) && isset($existSubmission) && Submission::find($submissionId)->task->user->find(Auth::id()) !== NULL ) ||
         ( Auth::user()->level['teacher'] || Auth::user()->level['administor'] )
       ){
        header('Content-Type:'.mime_content_type(storage_path('app/'.$file_name)));
        header('Content-Length: ' . filesize(storage_path('app/'.$file_name)));
        readfile(storage_path('app/'.$file_name));
      }else{
        abort(404);
      }

    }else{
      abort(404);
    }
  }
}
