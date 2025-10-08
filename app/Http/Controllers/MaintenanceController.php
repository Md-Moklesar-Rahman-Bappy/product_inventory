<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Maintenance;
use App\Models\Product;
use App\Http\Controllers\ActivityLogController;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with(['product', 'user'])->latest()->paginate(10);
        $trashedMaintenances = Maintenance::onlyTrashed()->with(['product', 'user'])->paginate(5);

        return view('maintenance.index', compact('maintenances', 'trashedMaintenances'));
    }

    public function create(Request $request)
    {
        $productId = $request->product_id;

        if (!$productId) {
            return redirect()->route('products.index')->with('error', 'No product selected for maintenance.');
        }

        $product = Product::findOrFail($productId);
        return view('maintenance.create', compact('product'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'description'  => 'required|string|max:255',
            'start_time'   => 'required|date|before_or_equal:now',
            'end_time'     => 'required|date|after_or_equal:start_time',
        ]);

        $validated['user_id'] = Auth::id();

        $maintenance = Maintenance::create([
            'product_id'   => $validated['product_id'],
            'user_id'      => $validated['user_id'],
            'description'  => $validated['description'],
            'performed_at' => $validated['end_time'],
            'start_time'   => $validated['start_time'],
            'end_time'     => $validated['end_time'],
        ]);

        ActivityLogController::logAction(
            'create',
            'Maintenance',
            $maintenance->id,
            '<span class="text-success fw-bold">Created</span> maintenance for <strong>Serial No: ' . $maintenance->product->serial_no . '</strong> — ' . e($validated['description'])
        );

        return redirect()->route('maintenance.index')->with('success', '🛠️ Maintenance record added successfully.');
    }

    public function show($id)
    {
        $maintenance = Maintenance::with(['product', 'user'])->withTrashed()->findOrFail($id);
        return view('maintenance.show', compact('maintenance'));
    }

    public function edit($id)
    {
        $maintenance = Maintenance::withTrashed()->findOrFail($id);
        $products = Product::all();
        return view('maintenance.edit', compact('maintenance', 'products'));
    }

    public function update(Request $request, $id)
    {
        $maintenance = Maintenance::withTrashed()->findOrFail($id);

        $validated = $request->validate([
            'description'  => 'required|string|max:255',
            'start_time'   => 'required|date',
            'end_time'     => 'required|date|after_or_equal:start_time',
        ]);

        $maintenance->update([
            'user_id'      => Auth::id(),
            'description'  => $validated['description'],
            'start_time'   => $validated['start_time'],
            'end_time'     => $validated['end_time'],
            'performed_at' => $validated['end_time'],
        ]);

        ActivityLogController::logAction(
            'update',
            'Maintenance',
            $maintenance->id,
            '<span class="text-primary fw-bold">Updated</span> maintenance for <strong>Serial No: ' . $maintenance->product->serial_no . '</strong> — ' . e($validated['description'])
        );

        return redirect()->route('maintenance.index')->with('success', '✏️ Maintenance record updated.');
    }

    public function destroy($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $serial = $maintenance->product->serial_no;
        $maintenance->delete();

        ActivityLogController::logAction(
            'delete',
            'Maintenance',
            $id,
            '<span class="text-danger fw-bold">Archived</span> maintenance for <strong>Serial No: ' . $serial . '</strong>'
        );

        return redirect()->route('maintenance.index')->with('success', '🗑️ Maintenance record archived.');
    }

    public function restore($id)
    {
        $maintenance = Maintenance::onlyTrashed()->findOrFail($id);
        $maintenance->restore();

        ActivityLogController::logAction(
            'restore',
            'Maintenance',
            $id,
            '<span class="text-success fw-bold">Restored</span> maintenance for <strong>Serial No: ' . $maintenance->product->serial_no . '</strong>'
        );

        return redirect()->route('maintenance.index')->with('success', '♻️ Maintenance record restored.');
    }

    // Optional: Permanently delete a maintenance record
    /*
    public function forceDelete($id)
    {
        $maintenance = Maintenance::onlyTrashed()->findOrFail($id);
        $serial = $maintenance->product->serial_no;
        $maintenance->forceDelete();

        ActivityLogController::logAction(
            'force_delete',
            'Maintenance',
            $id,
            '<span class="text-danger fw-bold">Permanently deleted</span> maintenance for <strong>Serial No: ' . $serial . '</strong>'
        );

        return redirect()->route('maintenance.index')->with('success', '❌ Maintenance record permanently deleted.');
    }
    */

    public function getProductBySerial($serial)
    {
        try {
            $product = Product::query()
                ->with(['model', 'category', 'brand'])
                ->whereRaw('UPPER(serial_no) = ?', [strtoupper($serial)])
                ->firstOrFail();

            return response()->json([
                'id' => $product->id,
                'name' => $product->product_name,
                'serial_no' => strtoupper($product->serial_no),
                'project_serial_no' => $product->project_serial_no,
                'model_name' => optional($product->model)->name,
                'category_name' => optional($product->category)->name,
                'brand_name' => optional($product->brand)->name,
                'warranty_status' => $product->warranty_status,
                'warranty_countdown' => $product->warranty_countdown,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
}
