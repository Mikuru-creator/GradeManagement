<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User; 

class UserController extends Controller
{
    // ログインフォーム表示
    public function loginForm()
    {
        return view('login');
    }

    // ログイン処理
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|max:72',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();// セッション固定化（なりすましログイン）を防ぐ
            return redirect()->route('menu');
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが間違っています。',
        ])->onlyInput('email');
    }

    // 新規登録フォーム表示
    public function registerForm()
    {
        return view('register');
    }

    // 新規登録処理
    public function register(Request $request)
    {
    $data = $request->validate([
            'user_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email|max:255|regex:/\A[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}\z/',
            'password' => 'required|confirmed|min:8|max:72|regex:/\A[a-zA-Z0-9]+\z/',
    ]);

    // ユーザー作成（パスワードは必ずハッシュ）
    $user = User::create([
        'user_name'     => $data['user_name'],
        'email'    => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    // そのままログインさせる
    Auth::login($user);
    $request->session()->regenerate();

    // 登録処理を書く
    return redirect()->route('menu');
    }
}
