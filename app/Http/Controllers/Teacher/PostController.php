<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
  public function form(){
    return view('pages.teachers.post.new', [
      'groups' => Group::get()
    ]);
  }

  public function new(Request $request){
    $validated = $request->validate([
      'title' => "string|required|max:100",
      'body' => "string|required|max:5000",
      "groups" => "required",
      'groups.*' => "string|exists:groups,id"
    ]);
    foreach($validated['groups'] as $group){
      $post = Post::create([
        'title' => encryptData($validated['title'], 'DATA_KEY'),
        'body' => encryptData($validated['body'], 'DATA_KEY'),
        'group_id' => $group,
        'user_id' => Auth::id()
      ]);

      if($request->file('files')!==NULL){
        foreach($request->file('files') as $file){
          File::create([
            'origin_name' => $file->getClientOriginalName(),
            'file_name' => $file->store('private'),
            'user_id' => Auth::id(),
            'post_id' => $post->id
          ]);
        }
      }

      Mail::send('mails.notify', ['title' => $validated['title']], function($message) use($group) {
        $message->to(decryptData(Auth::user()['email'], 'USER_KEY'));
        foreach(Group::find($group)->user as $user){
          $message->bcc(decryptData($user['email'], 'USER_KEY'));
        }
        $message->subject('掲示板が更新されました。');
      });

    }
    return redirect(route('posts'));
  }
}
