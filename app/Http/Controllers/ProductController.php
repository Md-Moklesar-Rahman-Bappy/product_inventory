<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Exports\CategoryProductExport;
use App\Exports\BrandProductExport;
use App\Exports\AssetModelProductExport;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\AssetModel;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\MaintenanceController;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 10);
        $search  = $request->input('search');
        $status  = $request->input('warranty_status');
        $query = Product::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('serial_no', 'like', '%' . $search . '%')
                ->orWhere('product_name', 'like', '%' . $search . '%');
            });
        }
        if ($status === 'active') {
            $query->whereDate('warranty_end', '>=', now());
        } elseif ($status === 'expired') {
            $query->whereDate('warranty_end', '<', now());
        }
        // 👇 Sort by newest first
        $query->orderBy('created_at', 'desc');

        $products = $query->paginate($perPage)->withQueryString();
        return view('products.index', compact('products'));

        $products = Cache::remember('products', 60, fn() => Product::all());
        return view('products.index', compact('products'));
    }
    public function create()
    {
        return view('products.create', [
            'categories' => Category::all(),
            'brands'     => Brand::all(),
            'models'     => AssetModel::all(),
        ]);
    }
    public function store(Request $request)
    {
        // 🔁 Normalize serials before validation
        $request->merge([
            'serial_no'         => strtoupper($request->serial_no),
            'project_serial_no' => strtoupper($request->project_serial_no),
        ]);
        // ✅ Validate input
        $validated = $request->validate([
            'product_name'       => 'required|string|max:255',
            'price'              => 'required|numeric|min:0|max:9999999.99',
            'category_id'        => 'required|exists:categories,id',
            'brand_id'           => 'required|exists:brands,id',
            'model_id'           => 'required|exists:asset_models,id',
            'serial_no'          => 'required|string|max:255|unique:products,serial_no',
            'project_serial_no'  => 'required|string|max:255|unique:products,project_serial_no',
            'position'           => 'nullable|string|max:255',
            'user_description'   => 'nullable|string|max:255',
            'remarks'            => 'nullable|string|max:255',
            'warranty_start'     => 'nullable|date',
            'warranty_end'       => 'nullable|date|after_or_equal:warranty_start',
        ]);
        // 🛠️ Create product
        $product = Product::create($validated);
        // 📝 Log activity
        ActivityLogController::logAction(
            'create',
            'Product',
            $product->id,
            '<span class="text-success fw-bold">Created</span> product: <strong>' . $product->product_name . '</strong><br>Serial No: <code>' . $product->serial_no . '</code>'
        );

        return redirect()->route('products.index')->with('success', 'Product created successfully');

        Cache::forget('products');
    }
    public function show(int $id)
    {
        $product = Product::with(['category', 'brand', 'model'])->findOrFail($id);
        return view('products.show', compact('product'));
    }
    public function edit(int $id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::all();
        $brands     = Brand::all();
        $models     = AssetModel::all();
        return view('products.edit', compact('product', 'categories', 'brands', 'models'));
    }
    public function update(Request $request, int $id)
    {
        // 🔁 Normalize serials before validation
        $request->merge([
            'serial_no'         => strtoupper($request->serial_no),
            'project_serial_no' => strtoupper($request->project_serial_no),
        ]);
        // ✅ Validate input
        $validated = $request->validate([
            'product_name'       => 'required|string|max:255',
            'price'              => 'required|numeric|min:0|max:9999999.99',
            'category_id'        => 'required|exists:categories,id',
            'brand_id'           => 'required|exists:brands,id',
            'model_id'           => 'required|exists:asset_models,id',
            'serial_no'          => 'nullable|string|max:255',
            'project_serial_no'  => 'nullable|string|max:255',
            'position'           => 'nullable|string|max:255',
            'user_description'   => 'nullable|string|max:255',
            'remarks'            => 'nullable|string|max:255',
            'warranty_start'     => 'nullable|date',
            'warranty_end'       => 'nullable|date|after_or_equal:warranty_start',
        ]);
        $product  = Product::findOrFail($id);
        $original = $product->getOriginal();
        $product->fill($validated); // Fill before checking changes
        if ($product->isClean()) {
            ActivityLogController::logAction(
                'update',
                'Product',
                $product->id,
                '<span class="text-muted fw-bold">No changes</span> made to product: <strong>' . $product->product_name . '</strong><br>Serial No: <code>' . $product->serial_no . '</code>'
            );
            return redirect()->route('products.index')->with('success', 'No changes were made.');
        }
        $product->save(); // Save changes
        $changes = $product->getChanges();
        $changedFields = collect($changes)->map(function ($value, $field) use ($original) {
            return '<span class="badge bg-warning text-dark me-1">' .
                Str::headline($field) . ': "' . ($original[$field] ?? '-') . '" → "' . $value . '"' .
                '</span>';
        })->implode(' ');
        ActivityLogController::logAction(
            'update',
            'Product',
            $product->id,
            '<span class="text-primary fw-bold">Updated</span> product: <strong>' . $product->product_name . '</strong><br>Serial No: <code>' . $product->serial_no . '</code><br>Changes: ' . $changedFields
        );
        return redirect()->route('products.index')->with('success', 'Product updated successfully');

        Cache::forget('products');
    }
    public function destroy(int $id)
    {
        try {
            $product = Product::findOrFail($id);

            // Prevent double deletion
            if ($product->trashed()) {
                return redirect()->route('products.index')->with('warning', 'Product already deleted.');
            }

            // Normalize and escape for safe logging
            $productName = e(strtoupper($product->product_name));
            $serial      = e(strtoupper($product->serial_no));
            $user        = auth()->user();

            // Soft delete
            $product->delete();

            // Log the deletion with audit info
            ActivityLogController::logAction(
                'delete',
                'Product',
                $id,
                "<span class='text-danger fw-bold'>Deleted</span> product: <strong>{$productName}</strong><br>Serial No: <code>{$serial}</code><br>By: <em>{$user->name}</em>"
            );

            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Failed to delete product: ' . $e->getMessage());
        }

        Cache::forget('products');
    }
    public function export(Request $request)
    {
        $format   = $request->get('format', 'csv');
        $products = Product::with(['category', 'brand', 'model'])->get();

        if ($format === 'csv') {
            $filename = 'products_export_' . now()->format('Ymd_His') . '.csv';
            $headers  = [
                'Content-Type'        => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function () use ($products) {
                $handle = fopen('php://output', 'w');

                // CSV Header row
                fputcsv($handle, [
                    'Product Name', 'Category', 'Brand', 'Model', 'Price',
                    'Serial No', 'Project Serial No', 'Position',
                    'User Description', 'Remarks', 'Warranty Start', 'Warranty End'
                ]);

                foreach ($products as $p) {
                    fputcsv($handle, [
                        $p->product_name,
                        $p->category?->category_name,
                        $p->brand?->brand_name,
                        $p->model?->model_name,
                        $p->price,
                        $p->serial_no,
                        $p->project_serial_no,
                        $p->position,
                        $p->user_description,
                        $p->remarks,
                        optional($p->warranty_start)->format('Y-m-d'),
                        optional($p->warranty_end)->format('Y-m-d'),
                    ]);
                }

                fclose($handle);
            };

            return Response::stream($callback, 200, $headers);
        }

        return back()->with('success', 'Exported successfully!');
    }
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        // Prevent double restore
        if (!$product->trashed()) {
            return redirect()->route('products.index')->with('warning', 'Product is already active.');
        }

        $product->restore();

        // Escape values for safe logging
        $productName = e(strtoupper($product->product_name));
        $serial      = e(strtoupper($product->serial_no));
        $user        = auth()->user();

        ActivityLogController::logAction(
            'restore',
            'Product',
            $product->id,
            "<span class='text-success fw-bold'>Restored</span> product: <strong>{$productName}</strong><br>Serial No: <code>{$serial}</code><br>By: <em>{$user->name}</em>"
        );

        return redirect()->route('products.index')->with('success', 'Product restored successfully');
    }
    public function warranties(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $status  = $request->input('warranty_status');

        $query = Product::whereNotNull('warranty_end');

        if ($status === 'active') {
            $query->whereDate('warranty_end', '>=', now());
        } elseif ($status === 'expired') {
            $query->whereDate('warranty_end', '<', now());
        }

        // 👇 Urgency-based sorting: expired → ≤7 days → ≤30 days → active → null
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

        $products = $query->paginate($perPage)->withQueryString();

        return view('warranties.index', compact('products'));
    }
    public function exportExcel()
    {
        return Excel::download(new ProductExport, 'products_' . now()->format('Ymd_His') . '.xlsx');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:2048',
        ]);

        Excel::import(new ProductImport, $request->file('file'));

        return redirect()->back()->with('success', 'Products imported successfully!');
    }
    public function exportCategoryWise()
    {
        return Excel::download(new CategoryProductExport, 'products_by_category_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function exportBrandWise($id)
    {
        $brand = Brand::findOrFail($id);

        return Excel::download(
            new BrandProductExport($id),
            'products_by_brand_' . Str::slug($brand->brand_name) . '_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function exportModelWise($id)
    {
        $model = AssetModel::findOrFail($id);

        return \Maatwebsite\Excel\Facades\Excel::download(
            new AssetModelProductExport($id),
            'products_by_model_' . \Illuminate\Support\Str::slug($model->model_name) . '_' . now()->format('Ymd_His') . '.xlsx'
        );
    }
    public function getWarrantyStartDateAttribute()
    {
        return optional($this->warranty_start)->format('Y-m-d');
    }

    public function getWarrantyEndDateAttribute()
    {
        return optional($this->warranty_end)->format('Y-m-d');
    }

}
