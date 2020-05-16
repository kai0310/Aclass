<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(\Illuminate\Http\Request $request)
    {
      $request->hash_login_id = hash('sha256', $request->hash_login_id);
      if(config('app.NOCAPTCHA_SECRET') !== NULL && config('app.NOCAPTCHA_SITEKEY') !== NULL){
        $this->validate($request, [
          'hash_login_id' => 'required|string',
          'password' => 'required|string',
          'g-recaptcha-response' => 'required|captcha'
        ]);
      }else{
        $this->validate($request, [
          'hash_login_id' => 'required|string',
          'password' => 'required|string'
        ]);
      }
    }
}
