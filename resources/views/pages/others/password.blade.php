@extends('layouts.common')

@section('style')
<style>
form div{display:inline-block;margin-top:.5rem;text-align:left}
input{font-size:1rem}
input[type="password"]{width:20rem;max-width:100%}
</style>
@endsection

@section('content')
<div class=card>
  <h3>パスワードの変更</h3>
  <form action="" method="POST" style=text-align:center>
    @csrf
    <div>
      <label id=nowPassword>現在のパスワード</label><br />
      <input type=password id=nowPassword name=nowPassword />
      @error('nowPassword')<br /><strong>{{ $message }}</strong>@enderror
    </div><br />
    <div>
      <label id=newPassword>新しいパスワード</label><br />
      <input type=password id=newPassword name=newPassword />
      @error('newPassword')<br /><strong>{{ $message }}</strong>@enderror
    </div><br />
    <div>
      <label id=newPassword_confirmation>新しいパスワードの再入力</label><br />
      <input type=password id=newPassword_confirmation name=newPassword_confirmation />
    </div><br />
    <div>
      <input class="button first-button" type=submit value="変更" />
    </div>
  </form>
</div>
@endsection
