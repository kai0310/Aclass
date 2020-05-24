<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
  public function change(Request $request){
    if(isset(Auth::user()['twofactor'])){
      $user = Auth::user();
      $user->twofactor = NULL;
      $user->save();
      $base64QRCode = NULL;
    }else{
      $user = Auth::user();
      $twoFactor = new \PragmaRX\Google2FAQRCode\Google2FA();
      $user->twofactor = encryptData($twoFactor->generateSecretKey(), 'USER_KEY');
      $user->save();
      $base64QRCode = $twoFactor->getQRCodeInline(
        'Aclass',
        decryptData(Auth::user()['login_id'], 'USER_KEY'),
        decryptData(Auth::user()['twofactor'], 'USER_KEY')
      );
    }
    return redirect()->back()->with(['result' => '変更に成功しました。', 'base64QRCode' => $base64QRCode]);
  }
}
