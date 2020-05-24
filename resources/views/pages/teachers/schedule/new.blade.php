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
  <h3>新しく予定を投稿する</h3>
  <form action="" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
      <label for=name>名前</label><br />
      <input type=text name=name id=name placeholder="タイトルを入力してください" value="{{ old('name') }}" required />
      @error('name')<br /><strong>{{ $message }}</strong>@enderror
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
      <label for=description>説明</label><br />
      <textarea name=description id=description required rows=10>{{ old('description') }}</textarea>
      @error('description')<br /><strong>{{ $message }}</strong>@enderror
    </div>
    <div>
      <label for=limit>日時</label><br />
      <input type=datetime-local name=time id=time value="{{$group['time']}}" required />
      @error('time')<br /><strong>{{ $message }}</strong>@enderror
    </div>
    <div style=text-align:right>
      <input type=submit />
    </div>
  </form>
</div>
@endsection
