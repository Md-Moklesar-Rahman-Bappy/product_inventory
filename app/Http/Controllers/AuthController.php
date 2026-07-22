<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            'permission' => 2,
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

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->status !== 'active') {
            return back()->with('error', 'Your account has been deactivated. Please contact support.');
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        ActivityLogController::logAction(
            'login',
            'User',
            $user->id,
            '<span class="text-success fw-bold">Logged in</span> as: <strong>'.e($user->name).'</strong> <span class="text-muted">('.e($user->email).')</span>'
        );

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

    // Update Profile
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'address' => 'nullable|string',
            'profile_photo_path' => 'nullable|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        $user->fill([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'designation' => $request->designation,
            'about' => $request->about,
            'address' => $request->address,
        ]);

        if ($request->hasFile('profile_photo_path')) {
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $image = $request->file('profile_photo_path')->store('uploads/users', 'public');
            $user->profile_photo_path = $image;
        }

        $user->save();

        ActivityLogController::logAction(
            'update',
            'User',
            $user->id,
            '<span class="text-primary fw-bold">Updated</span> profile: <strong>'.e($user->name).'</strong>'
        );

        return back()->with('success', '✅ Profile updated successfully.');
    }

    // Update Password
    public function passwordUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[!@#$%^&*]/|confirmed',
        ], [
            'password.regex' => 'Password must contain at least: 1 uppercase, 1 lowercase, 1 number, and 1 special character (!@#$%^&*)',
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->password = bcrypt($request->password);
        $user->save();

        ActivityLogController::logAction(
            'update',
            'User',
            $user->id,
            '<span class="text-warning fw-bold">Changed password</span> for user: <strong>'.e($user->name).'</strong>'
        );

        return back()->with('success', '✅ Password updated successfully.');
    }
}
