<?php
use App\Tools\CryptKey;

if(!function_exists('encryptData')){
  function encryptData($data, $configKeyName){
    $encrypt = new \Illuminate\Encryption\Encrypter(base64_decode(CryptKey::get($configKeyName)), 'AES-256-CBC');
    return $encrypt->encrypt($data);
  }
}

if(!function_exists('decryptData')){
  function decryptData($data, $configKeyName){
    $decrypt = new \Illuminate\Encryption\Encrypter(base64_decode(CryptKey::get($configKeyName)), 'AES-256-CBC');
    return $decrypt->decrypt($data);
  }
}
