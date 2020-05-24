@extends('layouts.common')

@section('style')
<style>
#userData{display:none}
#userEdit{margin:0 auto}
select{width: 100%}
tr td:first-of-type{text-align:right}
</style>
@endsection

@section('content')
<div class=card style=text-align:center>
  識別ID<br />
  <input type="number" name=user_id />
  <button id="search">検索</button>
</div>
<div class=card id=userData></div>
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$('#search').on('click', function(){
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "{{route('userInfo')}}",
    type: 'POST',
    data: {
      'data': $('input[name="user_id"]').val()
    },
  }).done(function(data) {
    var userDataInnerHTML = '<form action="" method=POST>@csrf';
    userDataInnerHTML += "<input type=hidden name=user_id value='" + data['user_id'] + "' />";
    userDataInnerHTML += "<table id=userEdit>";
    userDataInnerHTML += "<tr>";
    userDataInnerHTML += "<td><label for=level_id>レベル：</label></td>"
    userDataInnerHTML += "<td><select id=level_id name=level_id required>";
    data['levels'].forEach(level => {
      userDataInnerHTML += "<option value='" + level.id + "' " + ( level.id === data['level_id'] ? 'selected' : '' ) + ">" + level.name + "</option>";
    });
    userDataInnerHTML += "</select></td>";
    userDataInnerHTML += "</tr>";
    userDataInnerHTML += "<tr>";
    userDataInnerHTML += "<td><label for=name>名前：</label></td>"
    userDataInnerHTML += "<td><input id=name name=name type=text value='" + data['name'] + "' /></td>";
    userDataInnerHTML += "</tr>";
    userDataInnerHTML += "</table>";
    userDataInnerHTML += "<div style=text-align:right><input type=submit /></div>";
    userDataInnerHTML += "</form>";
    $('#userData').html(userDataInnerHTML).fadeIn();
  }).fail(function(data) {
  }).always(function(data){
    console.log(data);
  });
})
</script>
@endsection
