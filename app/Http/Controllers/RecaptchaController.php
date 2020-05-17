<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecaptchaController extends Controller
{
    public function create()
    {
        return view('recaptchacreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'login_id' => 'required|login_id',
            'password' => 'required|min:6',
            'g-recaptcha-response' => 'required|captcha', //reCAPTCHA評価
        ]);

        return "success";
    }
}