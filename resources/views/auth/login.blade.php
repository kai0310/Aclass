@extends('layouts.app')

@section('content')

<style media="screen">
*{text-align:center;}
body{font-family:sans-serif;}
input[type="email"],input[type="password"]{border:none;border-radius:0;}
input{font-size:1rem;line-height:1.5rem;padding:.25rem .5rem;background:#FFF;border-radius:.12rem;margin:.25rem;}
h3{text-align:center;font-size:2rem;line-height:4rem}
ul li{list-style:none;}
li{margin:2rem;}
button {display:inline-block;text-align:center;vertical-align:middle;user-select:none;padding:.375rem .75rem;font-size:1rem;line-height:1.5;border-radius:.25rem;color:#fff;background-color: #007bff;border-color: #007bff;}
.recaptcha{margin:2rem auto;width:300px;margin-top:20px;}
</style>

  <h3>ログイン</h3>
  <form method="POST" action="{{ route('login') }}">
    @csrf
    <ul>
      <li>
        <label for="email">ログインID</label>
        <input id="email" type="text" placeholder="あなたのログインID" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

        @error('email')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </li>

      <li>
        <label for="password">パスワード</label>
        <input id="password" type="password" placeholder="あなたのパスワード" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

        @error('password')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </li>
    </ul>

    <div class="recaptcha">
      {!! NoCaptcha::renderJs() !!}
      {!! NoCaptcha::display() !!}
    </div>

    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    <label for="remember">ログイン状態を保存する</label><br>

    <button type="submit" class="btn">ログイン</button>

    @if (Route::has('password.request'))
    <a class="btn btn-link" href="{{ route('password.request') }}">
      {{ __('Forgot Your Password?') }}
    </a>
    @endif
  </form>
@endsection
