@extends('layouts.common')

@section('style')
<style>
a.submission{text-decoration:none;background:linear-gradient(135deg, #0AF, #06F);color:#FFF;display:inline-block;padding:.25rem 1rem;border-radius:.25rem;cursor:pointer;box-shadow:0 2px 10px #0003;transition:all .25s}
a.submission.expired{background:linear-gradient(135deg, #CCC, #AAA);color:#FFF;pointer-events:none}
a.submission:not(:last-of-type){margin-right:.5rem}
a.submission:hover{box-shadow:none}
.image{width:calc(90% / 3);margin-left:calc( 10% / 4);vertical-align:top}
.fileLink{vertical-align:top;display:inline-block;padding:.25rem .5rem;width:calc(85% / 3);margin-left:calc(15% / 4);margin-top:.5rem;border-radius:.25rem;text-align:center;color:#333}
.image,.fileLink{text-decoration:none;box-shadow:0 2px 10px #0003;transition:all .25s}
.image:hover{box-shadow:none;transform:scale(1.1)}
.fileLink:hover{box-shadow:none;background:#333;color:#FFF;transform:scale(1.1)}
.with{white-space:pre-wrap;padding:1rem .5rem;border-bottom:2px solid #CCC}
.with:last-of-type{border:none}
@media screen and (max-width:750px){
  .image{width:100%}
  .fileLink{width:calc(85% / 2);margin-left:calc(15% / 3)}
}
</style>
@endsection

@section('content')
<div class=card>
  <div style="border-bottom:2px solid #CCC">
    <h3>{{decryptData($post['title'], 'DATA_KEY')}}</h3>
    <div style=font-size:.9rem>
      投稿者：{{decryptData($post->user['name'], 'USER_KEY')}}<br />
      投稿先：{{decryptData($post->group['name'], 'DATA_KEY')}}
    </div>
  </div>
  <div class=with>{{decryptData($post['body'], 'DATA_KEY')}}</div>

  <?php
  if($post->files !== NULL){

    $images = "";
    foreach($post->files as $file){
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
    foreach($post->files as $file){
      if(!exif_imagetype(storage_path('app/'.$file['file_name']))){
        $files .= "<a class='fileLink omit' download target=_blank href='".route('file', ['file_name' => $file['file_name']])."'>";
        $files .= "<i class='fas fa-download'></i>&nbsp;&nbsp;". (isset($file['origin_name']) ? $file['origin_name'] : '無題');
        $files .= "</a>";
      }
    }
    if($files !== ""){
      echo '<div class=with>',$files,'</div>';
    }
  }
  ?>
</div>
@endsection
