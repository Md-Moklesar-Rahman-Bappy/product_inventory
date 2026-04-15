<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::allSettings();

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'footer_credit' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:512',
        ]);

        Setting::set('app_name', $request->app_name);
        Setting::set('website', $request->website);
        Setting::set('phone', $request->phone);
        Setting::set('email', $request->email);
        Setting::set('address', $request->address);
        Setting::set('footer_credit', $request->footer_credit);

        if ($request->hasFile('logo')) {
            $oldLogo = Setting::get('logo_path');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = $request->file('logo')->store('uploads/settings', 'public');
            Setting::set('logo_path', $logoPath, 'image');
        }

        if ($request->hasFile('favicon')) {
            $oldFavicon = Setting::get('favicon_path');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }
            $faviconPath = $request->file('favicon')->store('uploads/settings', 'public');
            Setting::set('favicon_path', $faviconPath, 'image');
        }

        ActivityLogController::logAction(
            'update',
            'Setting',
            0,
            '<span class="text-primary fw-bold">Updated</span> application settings'
        );

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
