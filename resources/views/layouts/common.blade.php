<!DOCTYPE html>
<meta charset=UTF-8 />
<meta name=viewport content="width=device-width,initial-scale=1.0">
<meta name=csrf-token content="{{ csrf_token() }}">
<title>{{ config('app.name') }}</title>
<link rel=icon href="{{url('favicon.ico')}}" />
<link rel=apple-touch-icon sizes=180x180 href="{{url('apple-touch-icon.png')}}">
<link rel=stylesheet href=https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css />
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
<style>{!! str_replace("<", "&lt;", file_get_contents(resource_path('views/layouts/common.css'))) !!}</style>
@yield('style')
<header>
  <div class=inner>
    <img src="{{url('storage/logo.svg')}}" />
    <?php if(Auth::check()){ ?>
      <input type=checkbox id=menuToggle style=display:hidden />
      <label for=menuToggle>MENU</label>
      <div id=closeBoard></div>
      <ul>
        <li class="{{request()->routeIs('home')?'active':''}}"><a href="{{route('home')}}">トップ</a></li>
        <li class="{{request()->routeIs('tasks')?'active':''}}"><a href="{{route('tasks')}}">課題</a></li>
        <li class="{{request()->routeIs('posts')?'active':''}}"><a href="{{route('posts')}}">掲示板</a></li>
        <li class="{{request()->routeIs('others')?'active':''}}"><a href="{{route('others')}}">その他</a></li>
        <?php if(Auth::user()->level['teacher']){ ?>
          <li class="{{request()->routeIs('teacher')?'active':''}}"><a href="{{route('teacher')}}">教師用</a></li>
        <?php } ?>
        <?php if(Auth::user()->level['administor']){ ?>
          <li class="{{request()->routeIs('administor')?'active':''}}"><a href="{{route('administor')}}">管理者用</a></li>
        <?php } ?>
      </ul>
    <?php } ?>
  </div>
</header>
<main><div class=inner>@yield('content')</div></main>
<footer></footer>
<?php if(session()->get('result') !== NULL){ ?>
  <div class="message {{session()->get('result')}}"><?php
  if(session()->get('message') !== NULL){ echo htmlspecialchars(session()->get('message')); }
  else if(session()->get('result') === 'success'){echo '成功しました。';}
  else if(session()->get('result') === 'failed'){echo '失敗しました。';}
  else{echo '予想外の事態が発生しました。';}
  ?></div>
<?php } ?>
<script>
document.getElementById('closeBoard').onclick = function(){
  document.getElementById('menuToggle').checked = false;
}
</script>
@yield('script')
