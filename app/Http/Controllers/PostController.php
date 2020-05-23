<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Group;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
  public function index(){
    return view('pages.posts.index', [
      'posts' => User::where('id', Auth::id())->with('group.posts')->first()
    ]);
  }

  public function single($group_id, $post_id){
    if(Post::where('id', $post_id)->doesntExist()){
      abort(404);
    }else{
      if(Auth::user()->group()->find(Post::find($post_id)['group_id']) !== NULL){
        return view('pages.posts.single', [
          'post' => Post::where('id', $post_id)->with('user', 'group', 'files')->first()
        ]);
      }else{
        abort(404);
      }
    }
  }

  public function all($group_id){
    if(Group::where('id', $group_id)->doesntExist()){
      abort(404);
    }else{
      if(Auth::user()->group()->find($group_id) !== NULL){
        return view('pages.posts.all', [
          'group' => Group::find($group_id),
          'posts' => Post::where('group_id', $group_id)->with('user')->get()
        ]);
      }else{
        abort(404);
      }
    }
  }
}
