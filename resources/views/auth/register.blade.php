@extends('layouts.noLogin')

@section('style')
<style>
td{padding:.5rem 1rem}
</style>
@endsection

@section('content')
<div class=card>
  <h2 style=text-align:center>{{config('app.name')}} 管理者登録</h2>
  <form method=POST action="{{ route('register') }}">
    @csrf
    <table style="margin:0 auto">
      <tr>
      </tr>

      <tr>
        <td><label for=name>氏名</label></td>
        <td>
          <input id=name type=text class="@error('name') is-invalid @enderror" name=name value="{{old('name')}}" required autocomplete=name autofocus>
        </td>
      </tr>
      @error('name')<tr><td colspan=2><div class=error>{{ $message }}</div></td></tr>@enderror

      <tr>
        <td><label for=email>メールアドレス</label></td>
        <td>
          <input id=email type=email class="@error('email') is-invalid @enderror" name=email value="{{old('email')}}" required autocomplete=email>
        </td>
      </tr>
      @error('email')<tr><td colspan=2><div class=error>{{ $message }}</div></td></tr>@enderror

      <tr>
        <td><label for=password>パスワード</label></td>
        <td>
          <input id=password type=password class="@error('password') is-invalid @enderror" name=password required autocomplete=new-password>
        </td>
      </tr>
      @error('password')<tr><td colspan=2><div class=error>{{ $message }}</div></td></tr>@enderror

      <tr>
        <td><label for=password-confirm>パスワードの再入力</label></td>
        <td>
          <input id=password-confirm type=password name=password_confirmation required autocomplete=new-password>
        </td>
      </tr>

      <tr><td colspan=2 style=text-align:center><input type=submit value="登録" /></td></tr>

    </table>
  </form>
</div>
@endsection
