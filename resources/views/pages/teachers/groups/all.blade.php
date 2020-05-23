@extends('layouts.common')

@section('style')
<style>
#group{list-style:none}
.group{display:inline-block;width:calc(100% / 5);text-align:center;padding:.5rem 0;border-radius:.25rem;transition:all .25s}
.group a{color:inherit;text-decoration:none}
.group:hover{background:#333;color:#FFF;transform:scale(1.1)}
</style>
@endsection

@section('content')
<div class=card>
  <h3>グループ一覧</h3>
  <ul class=groups><?php foreach($groups as $group){
    echo "<li class='group omit'><a href='",route('groupSingle', [
      'group' => $group['id']
    ]),"'>",htmlspecialchars(decryptData($group['name'], 'DATA_KEY')),"&nbsp;&nbsp;<i class='fas fa-angle-double-right'></i></a></li>";
  } ?></ul>
</div>
@endsection
