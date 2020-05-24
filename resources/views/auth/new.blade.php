@extends('layouts.noLogin')


@section('style')
<style>
td{padding:1rem}
@media screen and (max-width:600px){
  td{padding:.25rem}
}
tr:nth-of-type(n+5) td, h2{text-align:center}
.g-recaptcha > div{margin:0 auto}
</style>

@section('content')
<div class=card>
  <h2>{{config('app.name')}} 新規会員登録</h2>
  <form method=POST action="">
    @csrf
    <table style="margin:0 auto">
      <tr>
        <td><label for=hash_login_id>ログインID</label></td>
        <td><input id=hash_login_id type=number class="@error('hash_login_id') is-invalid @enderror" name=hash_login_id value="{{ old('hash_login_id') }}" required autofocus /></td>
      </tr>
      @error('hash_login_id')<tr><td colspan=2><div class=error>{{ $message }}</div></td></tr>@enderror

      <tr>
        <td><label for=name>氏名</label></td>
        <td><input id=name type=text class="@error('hash_login_id') is-invalid @enderror" name=name value="{{ old('name') }}" required /></td>
      </tr>
      @error('name')<tr><td colspan=2><div class=error>{{ $message }}</div></td></tr>@enderror

      <tr>
        <td><label for=password>パスワード</label></td>
        <td><input id=password type=password class="@error('password') is-invalid @enderror" name=password required autocomplete=new-password></td>
      </tr>
      @error('password')<tr><td colspan=2><div class=error>{{ $message }}</div></td></tr>@enderror

      <tr>
        <td><label for=password-confirm>パスワードの再入力</label></td>
        <td><input id=password-confirm type=password name=password_confirmation required autocomplete=new-password></td>
      </tr>

      <tr><td colspan=2>{!! NoCaptcha::renderJs() !!}{!! NoCaptcha::display() !!}</td></tr>

      <tr><td colspan=2><input type=submit value="ログイン" /></td></tr>
    </table>
  </form>
</div>
@endsection
