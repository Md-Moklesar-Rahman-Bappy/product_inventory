<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // 📝 Show Registration Form
    public function register()
    {
        return view('auth.register');
    }

    // ✅ Handle Registration
    public function registerSave(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        event(new Registered($user)); // ✅ Send verification email immediately

        return redirect()->route('login')->with('success', 'Account created successfully. Please check your email to verify.');
    }


    // 🔐 Show Login Form
    public function login()
    {
        return view('auth.login');
    }

    // 🔓 Handle Login
    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ])->validate();

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // 📧 Send verification email only on first login
        if (!$user->hasVerifiedEmail()) {
            event(new Registered($user));
        }

        return redirect()->route('dashboard');
    }

    // 🚪 Logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // 👤 Profile View
    public function profile()
    {
        return view('profile');
    }
}
