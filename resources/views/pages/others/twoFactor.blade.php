@extends('layouts.common')

@section('style')
<style>
.ib{display:inline-block}
#twoFactorBackground{position:fixed;top:3rem;left:0;width:100%;height:100vh;background:#0003}
#twoFactor{position:absolute;top:50%;left:50%;transform:translateX(-50%) translateY(-50%);text-align:center}
</style>
@endsection

@section('content')
<div class=card>
  <h3>二要素認証</h3>
  <span class=ib>Aclassでは、『Google 認証システム アプリ』の利用をお勧めしています。</span>
  <span class=ib>詳細は以下のリンクよりご確認ください。</span><br />
  <a href=https://support.google.com/accounts/answer/1066447>https://support.google.com/accounts/answer/1066447</a>
</div>
<div class=card>
  <h3>二要素認証の設定</h3>
  現在のステータス：<i style="color:<?php echo isset(Auth::user()['twofactor']) ? '#0F6' : '#F60' ?>" class="fas fa-circle"></i>
  （<?php echo isset(Auth::user()['twofactor']) ? '有効です' : '無効です' ?>）<br />
  <form action="" method="POST">
    @csrf
    <input style=margin-top:.5rem type=submit value="<?php echo isset(Auth::user()['twofactor']) ? '無効' : '有効' ?>にする" />
  </form>
</div>

<?php if(session()->get('base64QRCode') !== NULL){ ?>
  <div id=twoFactorBackground></div>
  <div class=card id=twoFactor>
    <h4>2要素認証QRコード</h4>
    <img src="{{session()->get('base64QRCode')}}" /><br />
    <strong>この画像は、再び表示することはできません。</strong><br />
    <span style=font-size:.9rem>（周りの薄暗くなっている部分をクリックすると閉じます）</span>
  </div>
<?php } ?>
<?php session()->forget('base64QRCode') ?>
@endsection

@section('script')
<script>
  document.getElementById('twoFactorBackground').onclick = function(){
  document.getElementById('twoFactorBackground').style.display = 'none';
  document.getElementById('twoFactor').style.display = 'none';
}
</script>
@endsection
