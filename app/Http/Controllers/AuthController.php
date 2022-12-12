<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $authService;
    
    public function __construct() {
        if ($this->authService === null) {
            $this->authService = new AuthService();
        }
    }

    public function login_form()
    {
        return view('auth.login');
    }

    public function register_form()
    {
        return view('auth.register');
    }

    public function do_login(LoginRequest $request)
    {
        $objResult = $this->authService->doLogin($request->only(['email', 'password']));
        if ($objResult->Status) {
            return redirect()->intended('/dashboard')->with('success', $objResult->Message);
        }else {
            return back()->with('error', $objResult->Message)->withInput([
                'email' => $request->email
            ]);
        }
    }

    public function do_logout()
    {
        Auth::logout();
        return redirect()->route('auth.login_form')->with('success', 'Berhasil logout.');
    }

    public function do_register(RegisterRequest $request)
    {
        $objResult = $this->authService->doRegister((object) $request->validated());
        
        if (!$objResult->Status) {
            return back()->with('error', $objResult->Message);
        }

        return redirect()->route('auth.login_form')->with('success', $objResult->Message);
    }
}
