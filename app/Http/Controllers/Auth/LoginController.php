<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginDto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    // Форма авторизации
    public function loginForm(): View
    {
        return view('login');
    }

    // Авторизация
    public function login(LoginDto $dto): RedirectResponse
    {
        $user = Auth::attempt([
            'login' => $dto->login,
            'password' => $dto->password,
        ]);

        if (!$user) {
            return redirect()->back()
                ->withErrors(['auth' => 'Неверный логин или пароль.'])
                ->withInput();
        }

        return redirect()->intended(route('dashboard'));
    }

    // Выход
    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('login-form');
    }
}
