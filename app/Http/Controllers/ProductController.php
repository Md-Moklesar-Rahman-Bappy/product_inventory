<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CategoryProductExport;
use App\Exports\BrandProductExport;
use App\Exports\AssetModelProductExport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\AssetModel;
use App\Http\Controllers\ActivityLogController;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    // ──────── CRUD ─────────
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search  = $request->input('search');
        $status  = $request->input('warranty_status');

        $query = Product::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('serial_no', 'like', '%' . $search . '%')
                  ->orWhere('product_name', 'like', '%' . $search . '%')
                  ->orWhere('project_serial_no', 'like', '%' . $search . '%'); // ✅ added
            });
        }

        if ($status === 'active') {
            $query->whereDate('warranty_end', '>=', now());
        } elseif ($status === 'expired') {
            $query->whereDate('warranty_end', '<', now());
        }

        $query->orderBy('created_at', 'desc');

        $products = $query->paginate($perPage)->withQueryString();
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
        $request->merge([
            'serial_no'         => strtoupper($request->serial_no),
            'project_serial_no' => strtoupper($request->project_serial_no),
        ]);

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

        $product = Product::create($validated);

        ActivityLogController::logAction(
            'create',
            'Product',
            $product->id,
            '<span class="text-success fw-bold">Created</span> product: <strong>' . $product->product_name . '</strong><br>Serial No: <code>' . $product->serial_no . '</code>'
        );

        return redirect()->route('products.index')->with('success', 'Product created successfully');
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
        $request->merge([
            'serial_no'         => strtoupper($request->serial_no),
            'project_serial_no' => strtoupper($request->project_serial_no),
        ]);

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
        $product->fill($validated);

        if ($product->isClean()) {
            ActivityLogController::logAction(
                'update',
                'Product',
                $product->id,
                '<span class="text-muted fw-bold">No changes</span> made to product: <strong>' . $product->product_name . '</strong><br>Serial No: <code>' . $product->serial_no . '</code>'
            );
            return redirect()->route('products.index')->with('success', 'No changes were made.');
        }

        $product->save();
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
    }

    // ──────── Soft Delete / Restore / Force Delete ─────────
    public function destroy(int $id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id);

            if ($product->trashed()) {
                return redirect()->route('products.index')
                    ->with('warning', 'Product already deleted.');
            }

            $productName = e(strtoupper($product->product_name));
            $serial      = e(strtoupper($product->serial_no));
            $user        = auth()->user();

            $product->delete();

            ActivityLogController::logAction(
                'delete',
                'Product',
                $id,
                "<span class='text-danger fw-bold'>Deleted</span> product: <strong>{$productName}</strong><br>Serial No: <code>{$serial}</code><br>By: <em>{$user->name}</em>"
            );

            return redirect()->route('products.index')
                ->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('products.index')
                ->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        if (!$product->trashed()) {
            return redirect()->route('products.index')->with('warning', 'Product is already active.');
        }

        $product->restore();

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

        public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        if (!$product->trashed()) {
            return redirect()->route('products.index')->with('warning', 'Product must be deleted first.');
        }

        $productName = e(strtoupper($product->product_name));
        $serial      = e(strtoupper($product->serial_no));
        $user        = auth()->user();

        $product->forceDelete();

        ActivityLogController::logAction(
            'forceDelete',
            'Product',
            $id,
            "<span class='text-danger fw-bold'>Permanently Deleted</span> product: <strong>{$productName}</strong><br>Serial No: <code>{$serial}</code><br>By: <em>{$user->name}</em>"
        );

        return redirect()->route('products.index')->with('success', 'Product permanently deleted.');
    }

    // ──────── Export / Import ─────────
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
                        str_replace(["\r", "\n"], ' ', $p->user_description),
                        str_replace(["\r", "\n"], ' ', $p->remarks),
                        optional($p->warranty_start)->format('d/m/Y'),
                        optional($p->warranty_end)->format('d/m/Y'),
                    ]);
                }

                fclose($handle);
            };

            return Response::stream($callback, 200, $headers);
        }

        return back()->with('success', 'Exported successfully!');
    }

    public function exportExcel()
    {
        return Excel::download(new ProductExport, 'products_' . now()->format('Ymd_His') . '.xlsx');
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

        return Excel::download(
            new AssetModelProductExport($id),
            'products_by_model_' . Str::slug($model->model_name) . '_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:2048',
        ]);

        $import = new ProductImport;
        Excel::import($import, $request->file('file'));

        $message = "{$import->imported} products imported, {$import->skipped} rows skipped.";

        // Persist skipped rows until cleared
        session()->put('skippedRows', $import->skippedRows);

        return redirect()->back()->with('success', $message);
    }

    public function exportSkippedRows()
    {
        $skippedRows = session('skippedRows', []);

        if (empty($skippedRows)) {
            return redirect()->route('products.index')->with('warning', 'No skipped rows available to export.');
        }

        $filename = 'skipped_rows_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        return response()->stream(function () use ($skippedRows) {
            $handle = fopen('php://output', 'w');

            // ✅ Write UTF-8 BOM so Excel shows Bangla correctly
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header row
            fputcsv($handle, [
                'product_name','serial_no','project_serial_no','category','brand','model',
                'price','position','user_description','remarks','warranty_start','warranty_end','skip_reason'
            ]);

            foreach ($skippedRows as $row) {
                // Convert Excel serials to readable dates
                $warrantyStart = is_numeric($row['warranty_start'] ?? null)
                    ? \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['warranty_start']))->format('Y-m-d')
                    : ($row['warranty_start'] ?? '');

                $warrantyEnd = is_numeric($row['warranty_end'] ?? null)
                    ? \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['warranty_end']))->format('Y-m-d')
                    : ($row['warranty_end'] ?? '');

                fputcsv($handle, [
                    $row['product_name'] ?? '',
                    $row['serial_no'] ?? '',
                    $row['project_serial_no'] ?? '',
                    $row['category'] ?? '',
                    $row['brand'] ?? '',
                    $row['model'] ?? '',
                    $row['price'] ?? '',
                    $row['position'] ?? '',
                    $row['user_description'] ?? '',
                    $row['remarks'] ?? '',
                    $warrantyStart,
                    $warrantyEnd,
                    $row['skip_reason'] ?? 'Unknown',
                ]);
            }

            fclose($handle);
        }, 200, $headers);

        // ✅ Clear skipped rows after download
        session()->forget('skippedRows');
        session()->flash('success', 'Skipped rows exported and cleared.');
    }

    public function clearSkippedRows()
    {
        session()->forget('skippedRows');
        return redirect()->route('products.index')->with('success', 'Skipped rows cleared.');
    }

    // ──────── Warranty Overview ─────────
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

    // ──────── Sample Download ─────────
    public function downloadSample(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="product.csv"',
        ];

        $columns = [
            'product_name',
            'price',
            'category',
            'brand',
            'model',
            'serial_no',
            'project_serial_no',
            'position',
            'user_description',
            'remarks',
            'warranty_start',
            'warranty_end',
        ];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, [
                'Product Name',
                'Price',
                'Category',
                'Brand',
                'Model',
                'Serial',
                'Project Serial',
                'Position',
                'User Description',
                'Remarks',
                'Warranty Start',
                'Warranty End',
            ]);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
