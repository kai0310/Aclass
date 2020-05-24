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
  public function form() {
    return view('pages.teachers.post.new', [ 'groups' => Group::get() ]);
  }

  public function new(Request $request){
    $validated = $request->validate([
      'title' => "string|required|max:100",
      'body' => "string|required|max:5000",
      "groups" => "required",
      'groups.*' => "string|exists:groups,id"
    ]);

    //グループごとに投稿・ファイルの送信
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
    }

    // メールの送信処理
    if($request->input('mail')=='true'){

      // 送信先メールアドレスの配列作成
      $groupsUsers = Group::whereIn('id', $validated['groups'])->with('user')->whereHas('user', function ($q) {$q->whereNotNull('email');})->get();
      $users = [];
      foreach($groupsUsers as $groupUsers){
        foreach($groupUsers->user as $groupUser){
          if(!in_array(decryptData($groupUser['email'], 'USER_KEY'), $users)){
            $users[] = decryptData($groupUser['email'], 'USER_KEY');
          }
        }
      }

      Mail::send('mails.notify', [
        'title' => '掲示板に新しく投稿されました',
        'content' => $validated['title'],
        'link' => route('postSingle', ['group_id' => $group, 'post_id' => $post->id])
      ], function($message) use($user) {
        $message->to(decryptData(Auth::user()['email'], 'USER_KEY'));
        foreach($users as $user){
          $message->bcc($user); // BCCでメール送信
        }
        $message->subject('掲示板が更新されました。');
      });
      
    }

    // 複数のグループに別で投稿するので、return先は個別ページではなく一覧
    return redirect(route('posts'));
  }
}
