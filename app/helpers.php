<?php
if(!function_exists('encryptData')){
  function encryptData($data, $configKeyName){
    $encrypt = new \Illuminate\Encryption\Encrypter(base64_decode(str_replace('base64:', '', config('app.'.$configKeyName))), 'AES-128-CBC');
    return $encrypt->encrypt($data);
  }
}

if(!function_exists('decryptData')){
  function decryptData($data, $configKeyName){
    $decrypt = new \Illuminate\Encryption\Encrypter(base64_decode(str_replace('base64:', '', config('app.'.$configKeyName))), 'AES-128-CBC');
    return $decrypt->decrypt($data);
  }
}
