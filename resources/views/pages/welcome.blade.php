@extends('layouts.common')

@section('style')
<style>
.card{text-align:center}

.fadeIn{animation-duration:1s;animation-name:fadeIn;animation-fill-mode:both}
<?php
for($i=0;$i<9;$i++){
  echo "#fadeIn",($i+1),"{animation-delay:",($i*0.5),"s}";
}
?>

.fadeIn a{text-decoration:none;background:linear-gradient(135deg, #0AF, #06F);color:#FFF;display:inline-block;padding:.25rem 1rem;border-radius:.25rem;cursor:pointer;box-shadow:0 2px 10px #0003;transition:all .25s}
.fadeIn a:not(:last-of-type){margin-right:.5rem}
.fadeIn a:hover{box-shadow:none}

@keyframes fadeIn {
  0%{transform:translateY(1rem);opacity:0}
  100%{transform:translateY(0);opacity:1}
}
</style>
@endsection

@section('content')
<div class="card fadeIn" id=fadeIn1>
  <h2 class=fadeIn id=fadeIn2>Aclassへようこそ</h2>
  <div class=fadeIn id=fadeIn3>
    Aclassは、教師と生徒をつなぐための新たなツールです。<br />
    各利用団体の共通のサーバーを持たないため過負荷による障害が起こりにくいのが特徴です。
  </div>
</div>
<div class="card fadeIn" id=fadeIn4>
  <h2 class=fadeIn id=fadeIn5>Aclassでできること</h2>
  <div class=fadeIn id=fadeIn6>
    Aclassでは、課題を出したり、掲示板などで情報を周知させることができます。<br />
    また、投稿時の設定によりメールなどで通知をすることも可能です。
  </div>
</div>
<div class="card fadeIn" id=fadeIn7>
  <h2 class=fadeIn id=fadeIn8>学習を始めましょう！</h2>
  <div class=fadeIn id=fadeIn9 style=display:inline-block;text-align:left>
    <a href="{{route('tasks')}}">課題を確認する</a><a href="{{route('posts')}}">掲示板を確認する</a>
  </div>
</div>
@endsection
