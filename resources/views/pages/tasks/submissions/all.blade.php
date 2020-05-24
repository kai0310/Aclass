@extends('layouts.common')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.default.min.css">
<style>
#submissions th,#submissions td{text-align:center;font-size:1rem;color:inherit}
#submissions td a{display:inline-block;width:100%;color:inherit;text-decoration:none;transition:all .25s}
#submissions tr:hover{color:#06F}
</style>
@endsection

@section('content')
<div class=card>
  <h3>提出一覧</h3>
  <table id=submissions>
    <thead>
      <tr>
        <th>課題名</th>
        <th>グループ</th>
        <th>課題送信者</th>
        <th>提出日時</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($submissions as $submission){ ?>
        <tr>
          <td class=omit><a href="{{route('submissionSingle', ['submission_id' => $submission['id']])}}">{{decryptData($submission->task['title'], 'DATA_KEY')}}</a></td>
          <td class=omit><a href="{{route('submissionSingle', ['submission_id' => $submission['id']])}}">{{decryptData($submission->task->group['name'], 'DATA_KEY')}}</a></td>
          <td class=omit><a href="{{route('submissionSingle', ['submission_id' => $submission['id']])}}">{{decryptData($submission->task->user['name'], 'USER_KEY')}}</a></td>
          <td class=omit><a href="{{route('submissionSingle', ['submission_id' => $submission['id']])}}">{{date('n月j日 H:i', strtotime($submission['created_at']))}}</a></td>
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
