@extends('layouts.common')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.default.min.css">
<style>
#posts th,#posts td{text-align:center;font-size:1rem;color:inherit}
#posts td a{display:inline-block;width:100%;color:inherit;text-decoration:none;transition:all .25s}
#posts tr:hover{color:#06F}
</style>
@endsection

@section('content')
<div class=card>
  <h3>投稿一覧</h3>
  <table id=posts>
    <thead>
      <tr>
        <th>タイトル</th>
        <th>投稿者</th>
        <th>投稿日時</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($posts as $post){ ?>
        <tr>
          <?php $link = route('postSingle', ['group_id' => $group['id'], 'post_id' => $post['id']]) ?>
          <td class=omit><a href="{{$link}}">{{decryptData($post['title'], 'DATA_KEY')}}</a></td>
          <td class=omit><a href="{{$link}}">{{decryptData($post->user['name'], 'USER_KEY')}}</a></td>
          <td class=omit><a href="{{$link}}">{{$post['created_at']}}</a></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"></script>
<script>
$('#posts').tablesorter();
</script>
@endsection
