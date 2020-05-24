@extends('layouts.common')

@section('style')
<style>
form div{display:inline-block;margin-top:.5rem;text-align:left}
.error{color:#F50}
.success{color:#0C6}
input{font-size:1rem}
input[type="password"]{border:solid 1px #CCC;border-radius:.25rem;padding:.25rem .5rem;width:20rem;max-width:100%}
input[type="submit"]{padding:.25rem 1rem;border-radius:.25rem;background:linear-gradient(135deg, #0AF, #06F);color:#FFF;cursor:pointer;box-shadow:0 2px 10px #0003;transition:all .25s}
input[type="submit"]:hover{box-shadow:none}
</style>
@endsection

@section('content')
<div class=card>
  <h3>パスワードの変更</h3>
  <form action="" method="POST" style=text-align:center>
    @csrf
    @if (session('changePasswordError'))
    <div class=error><strong>{{session('changePasswordError')}}</strong></div><br />
    @endif
    @if (session('changePasswordSuccess'))
    <div class=success><strong>{{session('changePasswordSuccess')}}</strong></div><br />
    @endif
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
      <input type=submit value="変更" />
    </div>
  </form>
</div>
@endsection
