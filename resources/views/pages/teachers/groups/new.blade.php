@extends('layouts.common')

@section('style')
<style>
form > div:not(:first-of-type){margin-top:1rem}
input{padding:0 0.5rem;font-family:sans-serif}
input[type="text"]{display:inline-block;border:1px solid #CCC;font-size:1rem;width:100%}
input[type="submit"]{background:#06F;color:#FFF;font-size:1rem;border-radius:.25rem}
</style>
@endsection

@section('content')
<div class=card>
  <h3>グループを新しく作成する</h3>
  <form action="" method="POST">
    @csrf
    <div>
      <label for=name>グループ名</label><br />
      <input type=text name=name id=name placeholder="グループ名を入力してください" value="{{ old('name') }}" required />
      @error('name')<br /><strong>{{ $message }}</strong>@enderror
    </div>
    <div style=text-align:right>
      <input type=submit />
    </div>
  </form>
</div>
@endsection
