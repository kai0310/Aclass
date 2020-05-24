@extends('layouts.common')

@section('style')
<style>
h3{font-size:1.5rem}
#groups{list-style:none;margin:1rem 0}
#groups li{display:inline-block;margin-right:.5rem}
.tasks{display:none}
.task a{color:inherit;display:inline-block;padding:.25rem .5rem;width:100%;text-decoration:none;transition:all .2s}
.task a div{display:inline-block;vertical-align:top;width:80%;line-height:2rem}
.task a span{display:inline-block;width:20%;text-align:center;font-size:1.5rem;line-height:2rem}
.task a:hover{color:#06F}
@media screen and (min-width:1000px){
  .task{display:inline-block;width:50%}
}
input[name=selectGroups]:checked + .tasks{display:block}
</style>
@endsection

@section('content')
<div class=card>
  <h3>課題</h3>
  <?php if(count($user->group)>0){ ?>
    <ul id=groups>
      <?php $i = 0; ?>
      <?php foreach($user->group as $group){
        $i++;
        echo "<li class=group>";
        echo "<label class='button ",($i===1?'first-button':'second-button'),"' for=groupId",$group['id'],">";
        echo htmlspecialchars(decryptData($group['name'], 'DATA_KEY'))," <i class='fas fa-angle-down'></i></span>";
        echo "</label>";
        echo "</li>";
      } ?><li class=group><a href="{{route('submissionAll')}}" class="button first-button">提出一覧を見る <i class='fas fa-angle-right'></i></span></a></li>
    </ul>
    <?php $i = 0; ?>
    <?php foreach($user->group as $group){ ?>
      <input name=selectGroups type=radio id="groupId{{$group['id']}}" style=display:none {{$i===0?'checked':''}} />
      <div class=tasks>
        <?php $j = 0; ?>
        <?php foreach($group->tasks as $task){
          $j++;
          echo "<div class=task><a href='",route('taskSingle', ['task_id' => $task['id']]),"'>";
          echo "<div class=omit>",htmlspecialchars(decryptData($task['title'], 'DATA_KEY')),"</div><span><i class='fas fa-angle-right'></i></span>";
          echo "</a></div>";
        }
        echo ($j===0)?"<h4 style=width:100%;text-align:center>宇宙の彼方まで探しましたが課題は見つかりませんでした</h4>":""; ?>
      </div>
      <?php $i++; ?>
    <?php } ?>
  <?php }else{ ?>
    グループ所属情報なし
  <?php } ?>
</div>
@endsection

@section('script')
<script src=https://code.jquery.com/jquery-3.5.1.slim.min.js></script>
<script>
$('.group label').on('click', function(){
  $('.group label').removeClass('first-button');
  $('.group label').addClass('second-button');
  $(this).removeClass('second-button');
  $(this).addClass('first-button');
});
</script>
@endsection
