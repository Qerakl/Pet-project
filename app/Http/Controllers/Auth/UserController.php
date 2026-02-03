<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Переход на страницу регистрации
    public function viewRegister()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('Auth.register');
    }

    //Регистрация
    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/');
    }

    //Переход на страницу входа
    public function viewLogin()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('Auth.login');
    }

    //Вход
    public function login(UserLoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect('/');
        }
        return back()->withErrors([
            'email' => 'Неправильная почта или пароль',
        ])->onlyInput('email');
    }

    //Выход из аккаунта
    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect('/');
    }
}
