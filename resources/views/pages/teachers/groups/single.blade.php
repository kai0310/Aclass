@extends('layouts.common')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.default.min.css">
<style>
input[type="number"]{width:100%;text-align:left}
input[type="submit"]{margin-top:.5rem}
#users th,td{font-size:1rem}
#newUser{width:26rem;max-width:90%;margin:0 auto}
#newUser tr td{width:3rem;text-align:center}
#newUser tr td:first-of-type{width:20rem;max-width:calc(100% - 6rem)}
@media screen and (max-width:600px){
  #newUser{width:100%}
}
</style>
@endsection

@section('content')
<div class=card>
  <h3>グループ情報</h3>
  名前：{{decryptData($group['name'], 'DATA_KEY')}}<br />
  所属人数：{{$group->user()->count()}}
</div>
<div class=card>
  <h3>ユーザー情報</h3>
  <table id=users>
    <thead>
      <tr>
        <th>識別ID</th><th>名前</th><th>レベル</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach($group->user as $user){
        echo "<tr>";
        echo "<td>",$user['id'],"</td>";
        echo "<td>",htmlspecialchars(decryptData($user['name'], 'USER_KEY')),"</td>";
        echo "<td>",htmlspecialchars(decryptData($user->level['name'], 'DATA_KEY')),"</td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</div>
<div class=card>
  <h3>グループにユーザーを追加する</h3>
  <form action="{{route('groupNewUser', ['group'=> $group['id']])}}" method="POST">
    @csrf
    <div>
      <string>識別ID（ログインIDではありません）</string>
      <table id=newUser>
        <tr><td><input type=number name=userId[] id=userId required value="{{ old('loginId') }}"/></td><td class=remove><i class="fas fa-minus"></i></td><td class=add><i class="fas fa-plus"></i></td>
        </tr>
      </table>
    </div>
    <div style=margin-top:.5rem;text-align:right>
      <input type=submit />
    </div>
  </form>
</div>
<div class=card>
  <h3>グループからユーザーを削除する</h3>
  <form action="{{route('groupDeleteUser', ['group'=> $group['id']])}}" method="POST">
    @csrf
    <div style=text-align:center>
      <select name=userId>
        <option value="">ユーザーを選択してください</option>
        <?php
        foreach($group->user as $user){
          echo "<option value='",$user['id'],"'>",$user['id']," - ",htmlspecialchars(decryptData($user['name'], 'USER_KEY')),"</option>";
        }
        ?>
      </select>
    </div>
    <div style=text-align:right>
      <input type=submit />
    </div>
  </form>
</div>
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"></script>
<script>
$('#users').tablesorter();
$(document).on('click', '.remove', function(){
  if($('.remove').length > 1){
    $(this).parent().remove();
  }
});
$(document).on('click', '.add', function(){
  $(this).parent().clone().appendTo($(this).parent().parent()).children('td:first').find("input[type='number']").val("");
});
</script>
@endsection
