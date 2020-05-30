<?php
namespace app\Tools;

use Illuminate\Support\Facades\Storage;

class CryptKey {
  public static function create($keyName, $force = false){
    if(Storage::missing('key/'.$keyName.'.txt')||$force){
      Storage::put('key/'.$keyName.'.txt', base64_encode(random_bytes(32)));
      return true;
    }else{
      return false;
    }
  }

  public static function get($keyName){
    if(Storage::exists('key/'.$keyName.'.txt')){
      return Storage::get('key/'.$keyName.'.txt', $keyName);
    }else{
      return false;
    }
  }

  public static function check($keyName){
    if(Storage::exists('key/'.$keyName.'.txt')){
      $key = base64_decode(Storage::get('key/'.$keyName.'.txt', $keyName));
      if(mb_strlen($key, '8bit')!==32){ // 16文字じゃない
        return false;
      }
      return true;
    }else{
      return false;
    }
  }
}
