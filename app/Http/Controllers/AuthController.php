<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Show Registration Form
    public function register()
    {
        return view('auth.register');
    }

    // Handle Registration
    public function registerSave(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[!@#$%^&*]/',
        ], [
            'password.regex' => 'Password must contain at least: 1 uppercase, 1 lowercase, 1 number, and 1 special character (!@#$%^&*)',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Account created successfully. Please check your email to verify.');
    }

    // Show Login Form
    public function login()
    {
        return view('auth.login');
    }

    // Handle Login
    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ])->validate();

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Log login activity
        ActivityLogController::logAction(
            'login',
            'User',
            $user->id,
            '<span class="text-success fw-bold">Logged in</span> as: <strong>'.e($user->name).'</strong> <span class="text-muted">('.e($user->email).')</span>'
        );

        // Send verification email if not verified
        if (! $user->hasVerifiedEmail()) {
            event(new Registered($user));
        }

        return redirect()->route('dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Log logout activity before logging out
        if ($user) {
            ActivityLogController::logAction(
                'logout',
                'User',
                $user->id,
                '<span class="text-warning fw-bold">Logged out</span>: <strong>'.e($user->name).'</strong>'
            );
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Profile View
    public function profile()
    {
        return view('profile');
    }
}
