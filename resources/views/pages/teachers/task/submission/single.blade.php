@extends('layouts.common')

@section('style')
<style>
ul{list-style:none}
.description{font-size:.9rem;border-top:2px solid #CCC}
#submission{white-space:pre-wrap;word-wrap:break-word}
.border{border-bottom:2px solid #CCC;padding:1rem}
.border:last-of-type{border-bottom:none}
.image{width:calc(90% / 3);margin-left:calc( 10% / 4);vertical-align:top}
.fileLink{vertical-align:top;display:inline-block;padding:.25rem .5rem;width:calc(85% / 3);margin-left:calc(15% / 4);margin-top:.5rem;border-radius:.25rem;text-align:center;color:#333}
.image,.fileLink{text-decoration:none;box-shadow:0 2px 10px #0003;transition:all .25s}
.image:hover{box-shadow:none;transform:scale(1.1)}
.fileLink:hover{box-shadow:none;background:#333;color:#FFF;transform:scale(1.1)}
@media screen and (max-width:750px){
  .image{width:100%}
  .fileLink{width:calc(85% / 2);margin-left:calc(15% / 3)}
}
</style>
@endsection

@section('content')
<div class=card>
  <h3>提出詳細</h3>
  <div class="description border">
    <ul>
      <li>課題名：{{decryptData($task['title'], 'DATA_KEY')}}</li>
      <li>提出者：{{decryptData($submission->user['name'], 'USER_KEY')}}</li>
      <li>提出日時：{{decryptData($submission->user['name'], 'USER_KEY')}}</li>
      <li><a class="button first-button" href="{{route('taskSingle', ['task_id' => $task['id']])}}">課題を見る <i class="fas fa-angle-right"></i></a></li>
    </ul>
  </div>
  <div class=border id=submission>{{decryptData($submission['body'], 'DATA_KEY')}}</div>
  <?php
  $images = "";
  foreach($submission->files as $file){
    if(exif_imagetype(storage_path('app/'.$file['file_name']))){
      $images .= "<a class=imageLink target=_blank href='".route('file', ['file_name' => $file['file_name']])."'>";
      $images .= "<img class=image src='".route('file', ['file_name' => $file['file_name']])."' />";
      $images .= "</a>";
    }
  }
  if($images !== ""){
    echo '<div class=border>',$images,'</div>';
  }

  $files = "";
  foreach($submission->files as $file){
    if(!exif_imagetype(storage_path('app/'.$file['file_name']))){
      $files .= "<a class='fileLink omit' download target=_blank href='".route('file', ['file_name' => $file['file_name']])."'>";
      $files .= "<i class='fas fa-download'></i>&nbsp;&nbsp;". (isset($file['origin_name']) ? $file['origin_name'] : '無題');
      $files .= "</a>";
    }
  }
  if($files !== ""){
    echo '<div class=border>',$files,'</div>';
  }
  ?>
</div>
@endsection
