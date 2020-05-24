<?php

namespace App\Http\Controllers\Administor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
  public function create(Request $request){
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['nullable', 'string', 'email', 'max:255']
    ]);

    while(true){
        $login_id = random_int(10000000, 99999999);
        if(User::where('hash_login_id', hash('sha256', $login_id))->doesntExist()){
            break;
        }
    }

    $hash_login_id = hash('sha256', $login_id);
    $encrypt_login_id = encryptData($login_id, 'USER_KEY');
    $encrypt_email = encryptData($validated['email'], 'USER_KEY');
    $encrypt_name = encryptData(trim($validated['name']), 'USER_KEY');

    User::create([
        'login_id' => $encrypt_login_id,
        'hash_login_id' => $hash_login_id,
        'name' => $encrypt_name,
        'email' => $encrypt_email,
        'hash_email' => hash('sha256', $validated['email']),
        'password' => 'temporary password',
        'level_id' => 3,
        'temporary' => true,
        'temporary_password' => encryptData(base64_encode(random_bytes(8)), 'TEMP_KEY')
    ]);
    return '作成に成功しました。';
  }
}
