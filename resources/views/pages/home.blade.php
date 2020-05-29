@extends('layouts.common')

@section('style')
    <style>
        .cardItem{margin:1rem 0}
        h3{font-size:1.5rem}
        h4{font-size:1.1rem;line-height:1.5rem}
        .group{background:#005;color:#FFF;padding:.25rem .5rem;border-radius:.25rem;font-size:.9rem}
        .cardItem{position:relative}
        <?php foreach($schedules as $schedule) { ?>
  .cardItem#schedule{{$schedule['id']}}::before{display:block;background:#FFF;position:absolute;top:1.5rem;opacity:0;transition:all .25s;content:'{{decryptData($schedule['description'], 'DATA_KEY')}}'}
        .cardItem#schedule{{$schedule['id']}}:hover::before{opacity:1}
        <?php } ?>
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
        <?php foreach($schedules as $schedule){ ?>
        <div class="cardItem omit" id="schedule{{$schedule['id']}}">
            <h4 class=omit>{{date('n / j', strtotime($schedule['time']))}} - {{decryptData($schedule['name'], 'DATA_KEY')}}</h4>
            <?php foreach($schedule->groups as $group){ ?>
            <span class=group>{{decryptData($group['name'], 'DATA_KEY')}}</span>
            <?php } ?>
        </div>
        <?php } ?>
        <?php if(count($schedules)===0){ ?>
        <div class=cardItem><h4>直近30日間に予定はありません</h4></div>
        <?php } ?>
    </div>
    <div class="card">
        <h3>提出期限が迫っている課題</h3>
        <?php foreach ($tasks as $task){ ?>
        <div class="cardItem omit">
            <a href="{{route('taskSingle',['task_id'=>$task['id']])}}">
                <h4 class=omit>{{date('n月j日H時i分まで', strtotime($task['limit']))}} - {{decryptData($task['title'], 'DATA_KEY')}}</h4>
            </a>
        </div>
        <?php }
        if(count($tasks)===0){
        ?>
        <div class=cardItem><h4>提出期限の迫った課題はありません</h4></div>
        <?php } ?>
    </div>
@endsection
