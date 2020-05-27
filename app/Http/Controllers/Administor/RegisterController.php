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

    User::create([
        'login_id' => encryptData($login_id, 'USER_KEY'),
        'hash_login_id' => hash('sha256', $login_id),
        'name' => encryptData(trim($validated['name']), 'USER_KEY'),
        'email' => encryptData($validated['email'], 'USER_KEY'),
        'hash_email' => hash('sha256', $validated['email']),
        'level_id' => 3,
        'temporary' => true,
        'temporary_password' => encryptData(random_int(100000, 999999), 'TEMP_KEY'),
    ]);
    return '作成に成功しました。';
  }
}
