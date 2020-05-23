@extends('layouts.common')

@section('style')
<style>
.users,.levels{display:none}
form{text-align:center}
form div:nth-of-type(n+2){margin-top:1rem}
</style>
@endsection

@section('content')
<div class=card>
  <h3>ユーザーの権限設定</h3>
  <form action="" method="POST">
    @csrf
    <?php if($errors->any()){ foreach($errors->all() as $error){
      echo "<strong>",$error,"</strong><br />";
    } } ?>
    <div>
      <label>ユーザー識別ID：<input type="text" name=user_id id=user_id value="{{ old('user_id') }}" /></label>
    <div>
      <label>
        レベル：
        <select name=level_id>
          <option value="">レベルを選択してください</option>
          <?php foreach( $levels as $level ){ ?><option value="{{$level['id']}}">{{decryptData($level['name'], 'DATA_KEY')}}</option><?php } ?>
        </select>
      </lebel>
    </div>
    <div>
      <input type=submit value="保存" />
    </div>
  </form>
</div>
@endsection

@section('script')
<script src=https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js></script>
<script>
$('select[name="chooseGroup"]').change(function(){
  $('.users').css('display', 'none');
  $('#group' + $(this).val()).css('display', 'inline-block');
});
$('select[name="userId"]').change(function(){
  $('.levels').css('display', 'none');
  $('#user' + $(this).val()).css('display', 'inline-block');
});
</script>
@endsection
