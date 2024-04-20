<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Log::info('[ユーザー: {email}]ユーザーがログインしました', ['email' => $request->email]);
            return redirect()->intended('home')->with('toast', ['success', 'ログインしました']);
        }
    
        Log::info('[email: {email}, password: {password}]ユーザーがログインに失敗しました', [
            'email' => $request->email,
            'password' => $request->password
        ]);
        return back()->with('toast', ['danger', 'メールアドレスもしくはパスワードが異なります'])->onlyInput('email');
    }

    public function logout (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/login')->with('toast', ['info', 'ログアウトしました']);
    }
}
