@extends('layouts.common')

@section('style')
<style>
td{padding:1rem}
@media screen and (max-width:600px){
  td{padding:.25rem}
}
tr:nth-of-type(n+5) td, h2{text-align:center}
.g-recaptcha > div{margin:0 auto}
</style>
@endsection

@section('content')
<div class=card>
  <h2>{{config('app.name')}} ログイン</h2>
  <form method=POST action="{{ route('login') }}">
    @csrf
    <table style="margin:0 auto">
      <tr>
        <td><label for=hash_login_id>ログインID</label></td>
        <td><input id=hash_login_id type=number class="@error('hash_login_id') is-invalid @enderror" name=hash_login_id value="{{ old('hash_login_id') }}" required autofocus /></td>
      </tr>
      @error('hash_login_id')<tr><td colspan=2><span class=invalid-feedback role=alert><strong>{{ $message }}</strong></span></td></tr>@enderror

      <tr>
        <td><label for=password>パスワード</label></td>
        <td><input id=password type=password class="formInput @error('password') is-invalid @enderror" name=password required /></td>
      </tr>
      @error('password')<tr><td colspan=2><span class=invalid-feedback role=alert><strong>{{ $message }}</strong></span></td></tr>@enderror

      <tr>
        <td><label for=twofactor>2要素認証（有効時のみ）</label></td>
        <td><input id=twofactor type=number class="formInput @error('twofactor') is-invalid @enderror" name=twofactor /></td>
      </tr>
      @error('twofactor')<tr><td colspan=2><span class=invalid-feedback role=alert><strong>{{ $message }}</strong></span></td></tr>@enderror

      <tr><td colspan=2>{!! NoCaptcha::renderJs() !!}{!! NoCaptcha::display() !!}</td></tr>
      @error('g-recaptcha-response')<tr><td colspan=2><span class=invalid-feedback role=alert><strong>{{ $message }}</strong></span></td></tr>@enderror

      <tr>
        <td colspan=2>
          <input class=form-check-input type=checkbox name=remember id=remember {{ old('remember') ? 'checked' :'' }}>
          <label for=remember>ログイン状態を保存する</label>
        </td>
      </tr>

      <tr><td colspan=2><input type=submit value="ログイン" /></td></tr>

      <tr><td colspan=2>パスワードを忘れた場合は所属先の管理者までお問い合わせください。</td></tr>

    </table>
  </form>
</div>
@endsection
