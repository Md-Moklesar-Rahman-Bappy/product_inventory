<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\LicenseActivation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminLicenseController extends Controller
{
    public function index(Request $request)
    {
        $query = License::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('license_key', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('site_url', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $licenses = $query->latest()->paginate(20);

        return view('admin.licenses.index', compact('licenses'));
    }

    public function create()
    {
        return view('admin.licenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'product_id' => 'required|string|max:255',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $license = License::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'license_key' => License::generateKey(),
            'product_id' => $request->product_id,
            'status' => 'inactive',
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('admin.licenses.show', $license)
            ->with('success', 'License created successfully.');
    }

    public function show(License $license)
    {
        $activations = $license->activations()->latest()->paginate(10);

        return view('admin.licenses.show', compact('license', 'activations'));
    }

    public function updateStatus(Request $request, License $license)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,expired,revoked',
        ]);

        $oldStatus = $license->status;
        $newStatus = $request->status;

        $updates = ['status' => $newStatus];

        if ($newStatus === 'revoked' && $oldStatus !== 'revoked') {
            $updates['revoked_at'] = now();
        }

        $license->update($updates);

        return back()->with('success', "License status changed from {$oldStatus} to {$newStatus}.");
    }

    public function resetBinding(License $license)
    {
        $license->update([
            'site_url' => null,
            'app_url' => null,
            'machine_id' => null,
            'server_ip' => null,
            'activated_at' => null,
            'last_check_at' => null,
            'status' => 'inactive',
        ]);

        return back()->with('success', 'License domain/machine binding has been reset.');
    }

    public function destroy(License $license)
    {
        $license->delete();

        return redirect()->route('admin.licenses.index')
            ->with('success', 'License deleted permanently.');
    }
}
