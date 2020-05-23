@extends('layouts.common')

@section('style')
<style>
.with{white-space:pre-wrap;padding:1rem .5rem;border-bottom:2px solid #CCC}
.with:last-child{border:none}
.image{width:calc(90% / 3);margin-left:calc( 10% / 4);vertical-align:top}
.fileLink{vertical-align:top;display:inline-block;padding:.25rem .5rem;width:calc(85% / 3);margin-left:calc(15% / 4);margin-top:.5rem;border-radius:.25rem;text-align:center;color:#333}
.image,.fileLink{text-decoration:none;box-shadow:0 2px 10px #0003;transition:all .25s}
.image:hover{box-shadow:none;transform:scale(1.1)}
.fileLink:hover{box-shadow:none;background:#333;color:#FFF;transform:scale(1.1)}
textarea{width:100%}

@media screen and (max-width:750px){
  .image{width:100%}
  .fileLink{width:calc(85% / 2);margin-left:calc(15% / 3)}
}
</style>
@endsection

@section('content')
<div class=card>
  <div style="border-bottom:2px solid #CCC">
    <h3>{{decryptData($task['title'], 'DATA_KEY')}}</h3>
    <div style=font-size:.9rem>
      出題者：{{decryptData($task->user['name'], 'USER_KEY')}}<br />
      出題先：{{decryptData($task->group['name'], 'DATA_KEY')}}<br />
      期限：{{isset($task['limit']) ? date('n月 j日 H:i', strtotime($task['limit'])) : '期限なし'}}
    </div>
  </div>
  <div class=with>{{decryptData($task['body'], 'DATA_KEY')}}</div>

  <?php
  $images = "";
  foreach($task->files as $file){
    if(exif_imagetype(storage_path('app/'.$file['file_name']))){
      $images .= "<a class=imageLink target=_blank href='".route('file', ['file_name' => $file['file_name']])."'>";
      $images .= "<img class=image src='".route('file', ['file_name' => $file['file_name']])."' />";
      $images .= "</a>";
    }
  }
  if($images !== ""){
    echo '<div class=with>',$images,'</div>';
  }

  $files = "";
  foreach($task->files as $file){
    if(!exif_imagetype(storage_path('app/'.$file['file_name']))){
      $files .= "<a class='fileLink omit' download target=_blank href='".route('file', ['file_name' => $file['file_name']])."'>";
      $files .= "<i class='fas fa-download'></i>&nbsp;&nbsp;". (isset($file['origin_name']) ? $file['origin_name'] : '無題');
      $files .= "</a>";
    }
  }
  if($files !== ""){
    echo '<div class=with>',$files,'</div>';
  }
  ?>
</div>
<div class=card>
  <?php if((isset($task['limit'])&&strtotime($task['limit'])>strtotime(date('Y/m/d H:i:s'))) || !isset($task['limit'])){ ?>
    <form action="" method="POST" enctype="multipart/form-data">
      @csrf
      <h3>課題を提出する</h3>
      <div style=margin-top:.5rem>
        <label for=body>本文</label>
        <textarea id=body rows=10 name=body>{{old('body')}}</textarea>
      </div>
      <div style=margin-top:.5rem>
        <label for=files>添付ファイル</label><br />
        <input type=file id=files name=files[] multiple />
      </div>
      <div style=margin-top:.5rem;text-align:center><input type=submit class="submission" value="提出する" /></div>
    </form>
  <?php }else{ ?>
    <div style=text-align:center>期限切れです。</div>
  <?php } ?>
</div>
<?php if(session()->get('message')!==NULL&&session()->get('result')!==NULL){ ?>
  <div class="message {{session()->get('result')}}">{{session()->get('message')}}</div>
<?php } ?>
<?php session()->forget('message');session()->forget('result') ?>
@endsection
