@extends('layouts.common')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.default.min.css">
<style>
#submissions{width:100%}
th,td{text-align:center;font-size:1rem}
td a{color:inherit;text-decoration:none;transition:all .25s;display:inline-block;width:100%}
td a:hover{color:#06F}
</style>
@endsection

@section('content')
<div class=card>
  <h3>提出の表示</h3>
  <table id=submissions>
    <thead>
      <tr><th>提出者名</th><th>提出時刻</th><th>添付ファイル</th></tr>
    </thead>
    <tbody>
      <?php foreach($task->submissions as $submission){ ?>
        <tr>
          <td><a href="{{route('submissionCheck', ['submission' => $submission['id'], 'task' => $task['id']])}}">{{decryptData($submission->user['name'], 'USER_KEY')}}</a></td>
          <td>{{date('n月j日 H:i', strtotime($submission['created_at']))}}</td>
          <td>{{ $submission->files->count() > 0 ? 'O' : 'X' }}</td>
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
$('#submissions').tablesorter();
</script>
@endsection
