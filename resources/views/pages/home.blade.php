@extends('layouts.common')

@section('style')
<style>
.schedule{margin:1rem 0}
h3{font-size:1.5rem}
h4{font-size:1.1rem;line-height:1.5rem}
.group{background:#005;color:#FFF;padding:.25rem .5rem;border-radius:.25rem;font-size:.9rem}
</style>
@endsection

@section('content')
<div class=card>
  {{decryptData(Auth::user()->name, 'USER_KEY')}}さん。お帰りなさい。<br />
  ログインID：{{decryptData(Auth::user()->login_id, 'USER_KEY')}}<br />
  識別ID：{{Auth::id()}}
</div>
<div class=card>
  <h3>直近の予定</h3>
  <?php $i = 0; ?>
  <?php foreach($schedules as $schedule){ ?>
    <div class=schedule>
      <h4 class=omit>{{date('n / j', strtotime($schedule['time']))}} - {{$schedule['name']}}</h4>
      <?php foreach($schedule->groups as $group){ ?>
        <span class=group>{{$group['name']}}</span>
        <?php $i++; ?>
      <?php } ?>
    </div>
  <?php } ?>
  <?php if($i===0){ ?>
    <div class=schedule><h4>直近30日間に予定はありません</h4></div>
  <?php } ?>
</div>
@endsection
