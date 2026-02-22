<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\StringHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Notifications\SendCredentialsNotification;
use App\Http\Controllers\ActivityLogController;

class UserController extends Controller
{
    // 🧾 List Users
    public function index()
    {
        $users = User::latest()->paginate(10);
        $deletedUsers = User::onlyTrashed()->get();

        return view('users.index', compact('users', 'deletedUsers'));
    }

    // ➕ Show Create Form (Superadmin only)
    public function create()
    {
        if (!Auth::user()->isSuperadmin()) {
            abort(403, 'Access denied.');
        }

        return view('users.create');
    }

    // ✅ Store New User (Superadmin only)
    public function store(Request $request)
    {
        if (!Auth::user()->isSuperadmin()) {
            abort(403, 'Access denied.');
        }

        $request->merge([
            'mobile' => StringHelper::convertBengaliDigitsToEnglish($request->mobile),
        ]);

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:6',
            'mobile'      => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:255',
            'about'       => 'nullable|string',
            'address'     => 'nullable|string',
            'permission'  => 'required|integer|min:1|max:2',
            'profile_photo_path' => 'nullable|image|max:2048',
        ]);

        $user = new User();
        $user->fill([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => bcrypt($request->password),
            'mobile'      => $request->mobile,
            'designation' => $request->designation,
            'about'       => $request->about,
            'address'     => $request->address,
            'permission'  => $request->permission,
            'utype'       => $request->permission === 1 ? 'ADM' : 'USR',
            'status'      => 'active',
            'initial_password' => Crypt::encryptString($request->password),
        ]);

        if ($request->hasFile('profile_photo_path')) {
            $image = $request->file('profile_photo_path')->store('uploads/users', 'public');
            $user->profile_photo_path = $image;
        }

        $user->save();

        $user->sendEmailVerificationNotification();

        ActivityLogController::logAction(
            'create',
            'User',
            $user->id,
            '<span class="text-success fw-bold">Created</span> user: <strong>' . e($user->name) . '</strong>'
        );

        ActivityLogController::logAction(
            'verification-init',
            'User',
            $user->id,
            '<span class="text-warning fw-bold">Verification email sent</span> to user: <strong>' . e($user->name) . '</strong>'
        );

        return redirect()->route('users.index')->with('message', '✅ User created successfully.');
    }

    // 👁️ View Single User
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // ✏️ Edit User (Admin or Superadmin)
    public function edit(User $user)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isSuperadmin()) {
            abort(403, 'Access denied.');
        }

        return view('users.edit', compact('user'));
    }

    // 🔄 Update User (Admin or Superadmin)
    public function update(Request $request, User $user)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isSuperadmin()) {
            abort(403, 'Access denied.');
        }

        $request->merge([
            'mobile' => StringHelper::convertBengaliDigitsToEnglish($request->mobile),
        ]);

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'password'    => 'nullable|min:6',
            'mobile'      => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:255',
            'about'       => 'nullable|string',
            'address'     => 'nullable|string',
            'permission'  => 'required|integer|min:0|max:3',
            'profile_photo_path' => 'nullable|image|max:2048',
        ]);

        $user->fill([
            'name'        => $request->name,
            'email'       => $request->email,
            'mobile'      => $request->mobile,
            'designation' => $request->designation,
            'about'       => $request->about,
            'address'     => $request->address,
            'permission'  => $request->permission,
            'utype'       => $request->permission === 1 ? 'ADM' : 'USR',
        ]);

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

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
            '<span class="text-primary fw-bold">Updated</span> user: <strong>' . e($user->name) . '</strong>'
        );

        return redirect()->route('users.index')->with('message', '✏️ User updated successfully.');
    }

    // 🗑️ Delete User (Admin or Superadmin)
    public function destroy(User $user)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isSuperadmin()) {
            abort(403, 'Access denied.');
        }

        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->delete();

        ActivityLogController::logAction(
            'delete',
            'User',
            $user->id,
            '<span class="text-danger fw-bold">Deleted</span> user: <strong>' . e($user->name) . '</strong>'
        );

        return redirect()->route('users.index')->with('message', '🗑️ User deleted successfully.');
    }

    // ♻️ Restore User (Superadmin only)
    public function restore($id)
    {
        if (!Auth::user()->isSuperadmin()) {
            abort(403, 'Access denied.');
        }

        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        ActivityLogController::logAction(
            'restore',
            'User',
            $user->id,
            '<span class="text-success fw-bold">Restored</span> user: <strong>' . e($user->name) . '</strong>'
        );

        return redirect()->route('users.index')->with('message', '♻️ User restored successfully.');
    }

    // 🔁 Toggle Status (Superadmin only)
    public function toggleStatus(User $user)
    {
        if (!Auth::user()->isSuperadmin()) {
            abort(403, 'Only super admins can change user status.');
        }

        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot change your own status.');
        }

        $oldStatus = $user->status;
        $user->status = $oldStatus === 'active' ? 'deactive' : 'active';
        $user->save();

        // 🧹 Revoke sessions if deactivated
        if ($user->status === 'deactive') {
            DB::table('sessions')->where('user_id', $user->id)->delete();
        }

        // 📝 Log the status change
        ActivityLogController::logAction(
            'status-toggle',
            'User',
            $user->id,
            '<span class="text-warning fw-bold">Status changed</span> for user: <strong>' . e($user->name) . '</strong> from <em>' . ucfirst($oldStatus) . '</em> to <em>' . ucfirst($user->status) . '</em>'
        );

        return back()->with('success', 'User status updated successfully.');
    }

        // 🔐 Optional: Custom login method with status check
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email.']);
        }

        if ($user->status !== 'active') {
            return back()->withErrors(['email' => '🚫 Your account is currently deactivated. Please contact support.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => '❌ Incorrect password.']);
        }

        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')->with('message', '📧 Please verify your email before logging in.');
        }

        Auth::login($user);

        ActivityLogController::logAction(
            'login',
            'User',
            $user->id,
            '<span class="text-success fw-bold">Logged in</span> as user: <strong>' . e($user->name) . '</strong>'
        );

        return redirect()->intended('/dashboard')->with('message', '🎉 Welcome back, ' . $user->name . '!');
    }
}
