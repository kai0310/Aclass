@extends('layouts.common')

@section('style')
<style>
.goTop,.showAll{margin:.5rem 0}
.group,.goTop{margin-right:.5rem}
.showAll{text-decoration:none}
.post{display:inline-block;width:100%;padding:.5rem 0;color:inherit;text-decoration:none;vertical-align:top}
.post:hover{color:#06F}
.post span{display:inline-block}
.post span:first-of-type{width:80%}
.post span:last-of-type{width:20%;text-align:center}
@media screen and (min-width:1000px){
  .post{width:50%}
}
</style>
@endsection

@section('content')
<div class=card>
  <h3>掲示板</h3>
  <?php
  $i=0;
  foreach($posts->group as $group){
    $i++;
    echo "<span class='group button first-button' data-target=",$group['id'],">";
    echo htmlspecialchars(decryptData($group['name'], 'DATA_KEY'))," <i class='fas fa-angle-down'></i>";
    echo "</span>";
  }
  if($i<1){
    echo "グループ所属情報なし";
  }
  ?>
</div>
<?php foreach($posts->group as $group){ ?>
  <div class=card id="group{{$group['id']}}">
    <h4>{{decryptData($group['name'], 'DATA_KEY')}}</h4>
    <div class=posts>
      <?php $i = 0; foreach($group->posts as $post){
        $i++;
        if($i > 5){break;}
        echo "<a class=post href='",route('postSingle', ['group_id' => $group['id'], 'post_id'=> $post['id']]),"'>";
        echo "<span class=omit>",decryptData($post['title'], 'DATA_KEY'),"</span>";
        echo "<span><i class='fas fa-angle-right'></i></span>";
        echo "</a>";
      } if($i<1){echo "まだ、投稿はありません。";}?>
    </div>
    <span class='goTop button first-button'>TOPへ  <i class='fas fa-angle-up'></i></span><a class='showAll button first-button' href="{{route('postAll', ['group_id' => $group['id']])}}">全て見る  <i class='fas fa-angle-right'></i></a>
  </div>
<?php } ?>
@endsection

@section('script')
<script src=https://code.jquery.com/jquery-3.5.1.min.js></script>
<script>
$('.group').on('click', function(){
  $("html,body").animate({scrollTop:($('#group'+$(this).data('target')).offset().top - 58)})
});
$('.goTop').on('click', function(){
  $("html,body").animate({scrollTop:0})
})
</script>
@endsection
