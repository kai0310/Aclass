@extends('layouts.common')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.default.min.css">
<style>
#tasks{width:100%}
th,td{text-align:center;font-size:1rem}
td a{color:inherit;text-decoration:none;transition:all .25s}
td a:hover{color:#06F}
</style>
@endsection

@section('content')
<div class=card>
  <h3>全課題の表示</h3>
  <table id=tasks>
    <thead>
      <tr><th>課題名</th><th>送信先</th><th>送信者</th><th>送信日時</th><th>期限</th><th>提出数・確認</th></tr>
    </thead>
    <tbody>
      <?php foreach($tasks as $task){ ?>
        <tr>
          <td><a href="{{route('taskSingle', ['task_id' => $task['id']])}}">{{decryptData($task['title'], 'DATA_KEY')}}</a></td>
          <td>{{decryptData($task->group['name'], 'DATA_KEY')}}</td>
          <td>{{decryptData($task->user['name'], 'USER_KEY')}}</td>
          <td>{{date('N月j日 H:i', strtotime($task['created_at']))}}</td>
          <td>{{date('N月j日 H:i', strtotime($task['limit']))}}</td>
          <td><a href="{{route('submissionCheckAll', ['task' => $task['id']])}}">{{$task->submissions->count()}}回</a></td>
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
$('#tasks').tablesorter();
</script>
@endsection
