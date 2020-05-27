@extends('layouts.common')

@section('style')
<style>
#changeUserLevelId{margin:0 auto}
#changeUserLevelId tr:nth-of-type(n+2) td{padding-top:1rem}
#changeUserLevelId tr:not(:last-of-type) input, #changeUserLevelId select{width: 100%}
#changeUserLevelId tr:not(:last-of-type) td:first-of-type{text-align:right}
#changeUserLevelId tr:last-of-type td{text-align: right}
</style>
@endsection

@section('content')
<div class=card>
  <h3>ユーザーの権限設定</h3>
  <form action="" method="POST">
    @csrf
    <?php if($errors->any()){ ?>
      <div class="message failed">
        <?php foreach($errors->all() as $error){ ?>
          - {{$error}}<br />
        <?php } ?>
      </div>
    <?php } ?>
    <table id=changeUserLevelId>
      <tbody>
        <tr>
          <td><label for=user_id>ユーザー識別ID：</label></td>
          <td><input type=number class="@error('user_id') is-invalid @enderror" name=user_id id=user_id value="{{ old('user_id') }}" required /></td>
        </tr>
        <tr>
          <td><label for=level_id>レベル：</lebel></td>
          <td>
            <select name=level_id class="@error('level_id') is-invalid @enderror" required>
              <option>レベルを選択してください</option>
              <?php foreach( $levels as $level ){ ?>
                <option value="{{$level['id']}}" {{(old('level_id')==$level['id'] ? 'selected' : '')}}>
                  {{decryptData($level['name'], 'DATA_KEY')}}
                </option>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr><td colspan=2><input type=submit /></td></tr>
      </tbody>
    </table>
  </form>
</div>
@endsection
