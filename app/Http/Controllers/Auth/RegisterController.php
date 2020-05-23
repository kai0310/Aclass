<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Level;
use App\Group;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if(Level::count()<1){
            Level::insert([
                ['name' => encryptData('管理者', 'DATA_KEY'), 'teacher' => true, 'administor' => true],
                ['name' => encryptData('先生', 'DATA_KEY'), 'teacher' => true, 'administor' => false],
                ['name' => encryptData('生徒', 'DATA_KEY'), 'teacher' => false, 'administor' => false],
            ]);

            Group::insert([
                ['name' => encryptData('全校', 'DATA_KEY')],
                ['name' => encryptData('教職員', 'DATA_KEY')],
                ['name' => encryptData('生徒', 'DATA_KEY')],
            ]);
        }

        if(Level::find(1)->users()->count()<1){
            $level_id = 1;
        }else{
            $level_id = 3;
        }

        while(true){
            $login_id = random_int(10000000, 99999999);
            if(User::where('hash_login_id', hash('sha256', $login_id))->doesntExist()){
                break;
            }
        }

        $hash_login_id = hash('sha256', $login_id);
        $encrypt_login_id = encryptData($login_id, 'USER_KEY');
        $encrypt_email = encryptData($data['email'], 'USER_KEY');
        $encrypt_name = encryptData(trim($validated['name']), 'USER_KEY');

        return User::create([
            'login_id' => $encrypt_login_id,
            'hash_login_id' => $hash_login_id,
            'name' => $encrypt_name,
            'email' => $encrypt_email,
            'hash_email' => hash('sha256', $data['email']),
            'password' => Hash::make($data['password']),
            'level_id' => $level_id
        ]);
    }

    protected function redirectTo()
    {
        return '/welcome';
    }
}
