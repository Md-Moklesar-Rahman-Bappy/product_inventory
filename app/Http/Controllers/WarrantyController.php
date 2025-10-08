<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ActivityLogController;

class WarrantyController extends Controller
{
    /**
     * Display a listing of products with urgency-based sorting.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $status  = $request->input('warranty_status');

        $query = Product::withUrgencyOrder()->whereNotNull('warranty_end');

        if ($status === 'active') {
            $query->whereDate('warranty_end', '>=', now());
        } elseif ($status === 'expired') {
            $query->whereDate('warranty_end', '<', now());
        }

        $products = $query->paginate($perPage)->withQueryString();

        return view('warranties.index', compact('products'));
    }

    /**
     * Show the form for editing warranty info.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('warranties.edit', compact('product'));
    }

    /**
     * Update warranty info for a product.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'warranty_start' => 'nullable|date',
            'warranty_end'   => 'nullable|date|after_or_equal:warranty_start',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        ActivityLogController::logAction(
            'update',
            'Product',
            $product->id,
            "<span class='text-primary fw-bold'>Updated</span> warranty info for: <strong>" . e($product->product_name) . "</strong><br>Serial No: <code>" . e($product->serial_no) . "</code>"
        );

        return redirect()->route('warranties.index')->with('success', 'Warranty updated successfully');
    }

    /**
     * Restore a soft-deleted product.
     */
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        if (!$product->trashed()) {
            return redirect()->route('warranties.index')->with('warning', 'Product is already active.');
        }

        $product->restore();

        ActivityLogController::logAction(
            'restore',
            'Product',
            $product->id,
            "<span class='text-success fw-bold'>Restored</span> warranty for: <strong>" . e($product->product_name) . "</strong>"
        );

        return redirect()->route('warranties.index')->with('success', 'Warranty restored successfully');
    }

    /**
     * Export warranty data as CSV.
     */
    public function export(Request $request)
    {
        $status = $request->input('warranty_status');

        $query = Product::query()->whereNotNull('warranty_end');

        if ($status === 'active') {
            $query->whereDate('warranty_end', '>=', now());
        } elseif ($status === 'expired') {
            $query->whereDate('warranty_end', '<', now());
        }

        $query->select('*')
              ->selectRaw("
                  CASE
                      WHEN warranty_end IS NULL THEN 4
                      WHEN warranty_end < NOW() THEN 0
                      WHEN DATEDIFF(warranty_end, NOW()) <= 7 THEN 1
                      WHEN DATEDIFF(warranty_end, NOW()) <= 30 THEN 2
                      ELSE 3
                  END AS urgency_level
              ")
              ->orderBy('urgency_level')
              ->orderBy('warranty_end');

        $products = $query->get();

        $filename = 'warranty_export_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($products) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Product Name', 'Serial No', 'Project Serial No',
                'Warranty Start', 'Warranty End', 'Warranty Status'
            ]);

            foreach ($products as $p) {
                fputcsv($handle, [
                    $p->product_name,
                    $p->serial_no,
                    $p->project_serial_no,
                    optional($p->warranty_start)->format('Y-m-d'),
                    optional($p->warranty_end)->format('Y-m-d'),
                    $p->warranty_end->isPast() ? 'Expired' : 'Active',
                ]);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }
}
