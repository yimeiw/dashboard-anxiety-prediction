<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
    {
        $request->validate([
            Fortify::username() => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(Fortify::username(), 'password');

        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(config('fortify.home'));
        }

        $userExists = \App\Models\User::where(Fortify::username(), $request->{Fortify::username()})->exists();

        if (! $userExists) {
            return redirect()->route('register')->with('info', 'Email belum terdaftar, silakan buat akun baru.');
        }

        throw ValidationException::withMessages([
            Fortify::username() => __('These credentials do not match our records.'),
        ]);
    }

}
