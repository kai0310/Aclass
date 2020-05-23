@extends('layouts.common')

@section('style')
<style>
input[type="text"],input[type="email"]{width:100%;text-align:left}
input[type="submit"]{margin-top:.5rem}
input[type="text"]:disabled,input[type="email"]:disabled{background:#F5F5F5}
#users th,td{font-size:1rem}
#newUser{width:90%;margin:0 auto}
.remove,.send{cursor:pointer;width:2rem;text-align:center;transition:all .25s;color:#333;background:#FFF}
.remove:hover,.send:hover{color:#FFF;background:#333;transform:scale(1.1);position:relative}
.remove:hover::before,.send:hover::before{display:inline-block;position:absolute;top:3rem;right:0;color:#FFF;background:#333;font-size:.8rem}
.remove:hover::before{content:"この行を削除する";width:8rem}
.send:hover::before{content:"この行を登録する";width:8rem}
.name,.email{width:calc((100% - 4rem) / 2)}
@media screen and (max-width:600px){
  #newUser{width:100%}
  .remove,.send{width:1.5rem}
  .name,.email{width:calc((100% - 3rem) / 2)}
}
</style>
@endsection

@section('content')
<div class=card>
  <h3>ユーザー一括登録</h3>
  <div>
    <table id=newUser>
      <tr class=clear>
        <td class=name><input type=text placeholder="氏名" /></td>
        <td class=email><input type=email placeholder="メールアドレス" /></td>
        <td class=remove><i class="fas fa-minus"></i></td>
        <td class=send><i class="fas fa-paper-plane"></i></td>
      </tr>
    </table>
  </div>
</div>
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).on('click', '.remove', function(){
  if( !$(this).hasClass('disable') && $('.remove').length > 1){
    $(this).parent().remove();
  }
});

$(document).on('keydown', '.name:last input, .email:last input', function(e){
  if(e.keyCode!==8&&e.keyCode!==46&&$(this).parent().parent().children('.name').children('input').val()==""&&$(this).parent().parent().children('.email').children('input').val()==""){
    $(this).parent().parent().clone().appendTo($(this).parent().parent().parent());
  }
});

$(document).on('click', '.send', function(){
  $(this).parent().children('.remove').addClass('disable');
  $(this).parent().children('.name').children('input').prop('disabled', true);
  $(this).parent().children('.email').children('input').prop('disabled', true);
  var ele = $(this);

  if($(this).parent().children('.name').children('input').val()==""){
    $(this).parent().children('.remove').removeClass('disable');
    $(this).parent().children('.name').children('input').prop('disabled', false);
    $(this).parent().children('.email').children('input').prop('disabled', false);
    return false;
  }

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '',
    type: 'POST',
    data: {
      'name': $(this).parent().children('.name').children('input').val(),
      'email': $(this).parent().children('.email').children('input').val()
    },
  }).done(function(data) {
    ele.parent().remove();
  }).fail(function(data) {
    ele.parent().children('.remove').removeClass('disable');
    ele.parent().children('.name').children('input').prop('disabled', false);
    ele.parent().children('.email').children('input').prop('disabled', false);
  }).always(function(data){
    console.log(data);
  });
});
</script>
@endsection
