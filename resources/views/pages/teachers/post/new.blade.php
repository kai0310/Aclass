@extends('layouts.common')

@section('style')
<style>
form > div:not(:first-of-type){margin-top:1rem}
input[type="text"],textarea{width:100%}
.group{display:inline-block;padding:.25rem .5rem}
</style>
@endsection

@section('content')
<div class=card>
  <h3>新しく掲示板に投稿する</h3>
  <form action="" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
      <label for=title>タイトル</label><br />
      <input type=text name=title id=title placeholder="タイトルを入力してください" value="{{ old('title') }}" required />
      @error('title')<br /><strong>{{ $message }}</strong>@enderror
    </div>
    <div>
      <span>投稿先グループ</span><br />
      <div id=groups>
        <?php foreach($groups as $group){ ?>
          <span class=group>
            <input type=checkbox name=groups[] id="group{{$group['id']}}" value="{{$group['id']}}" />
            <label for="group{{$group['id']}}"><span>{{decryptData($group['name'], 'DATA_KEY')}}</span></label>
          </span>
        <?php } ?>
      </div>
      @error('groups[]')<br /><strong>{{ $message }}</strong>@enderror
    </div>
    <div>
      <label for=body>本文</label><br />
      <textarea name=body id=body required rows=10>{{ old('body') }}</textarea>
      @error('body')<br /><strong>{{ $message }}</strong>@enderror
    </div>
    <div>
      <input type=checkbox name=mail id="mail" value="true"/>
      <label for="mail"><span>メールで通知する</span></label>
    </div>
    <div>
      <label for=files>添付ファイル</label><br />
      <input type=file name=files[] id=files multiple />
    </div>
    <div style=text-align:right>
      <input type=submit />
    </div>
  </form>
</div>
@endsection
