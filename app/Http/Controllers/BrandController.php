<?php

namespace App\Http\Controllers;

use App\Imports\BrandImport;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::query()->withCount('products');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('brand_name', 'like', "%{$search}%");
        }

        $brands = $query->latest()->paginate(10);
        $trashedBrands = Brand::onlyTrashed()->paginate(5);

        return view('brands.index', compact('brands', 'trashedBrands'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255|unique:brands,brand_name',
        ]);

        $brand = Brand::create($request->only('brand_name'));

        ActivityLogController::logAction(
            'create',
            'Brand',
            $brand->id,
            '<span class="text-success fw-bold">Created</span> brand: <strong>'.$brand->brand_name.'</strong>'
        );

        return redirect()->route('brands.index')
            ->with('success', '✅ Brand created successfully.');
    }

    public function show($id)
    {
        $brand = Brand::withTrashed()->findOrFail($id);

        return view('brands.show', compact('brand'));
    }

    public function edit($id)
    {
        $brand = Brand::withTrashed()->findOrFail($id);

        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255|unique:brands,brand_name,'.$id,
        ]);

        $brand = Brand::withTrashed()->findOrFail($id);
        $brand->update($request->only('brand_name'));

        ActivityLogController::logAction(
            'update',
            'Brand',
            $brand->id,
            '<span class="text-primary fw-bold">Updated</span> brand: <strong>'.$brand->brand_name.'</strong>'
        );

        return redirect()->route('brands.index')
            ->with('success', '✏️ Brand updated successfully.');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brandName = $brand->brand_name;
        $brand->delete();

        ActivityLogController::logAction(
            'delete',
            'Brand',
            $id,
            '<span class="text-danger fw-bold">Archived</span> brand: <strong>'.$brandName.'</strong>'
        );

        return redirect()->route('brands.index')
            ->with('success', '🗑️ Brand archived successfully.');
    }

    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->restore();

        ActivityLogController::logAction(
            'restore',
            'Brand',
            $id,
            '<span class="text-success fw-bold">Restored</span> brand: <strong>'.$brand->brand_name.'</strong>'
        );

        return redirect()->route('brands.index')
            ->with('success', '♻️ Brand restored successfully.');
    }

    public function forceDelete($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brandName = $brand->brand_name;
        $brand->forceDelete();

        ActivityLogController::logAction(
            'force_delete',
            'Brand',
            $id,
            '<span class="text-danger fw-bold">Permanently deleted</span> brand: <strong>'.$brandName.'</strong>'
        );

        return redirect()->route('brands.index')
            ->with('success', '❌ Brand permanently deleted.');
    }

    public function products($id)
    {
        $brand = Brand::withTrashed()->findOrFail($id);

        $query = Product::with(['model', 'category'])
            ->where('brand_id', $brand->id)
            ->orderBy('created_at', 'desc');

        if (request()->filled('search')) {
            $query->where('serial_no', 'like', '%'.request('search').'%');
        }

        $products = $query->paginate(10);

        return view('brands.products', compact('brand', 'products'));
    }

    // Import
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:2048',
        ]);

        $import = new BrandImport;
        Excel::import($import, $request->file('file'));

        $message = "Import completed: {$import->created} created, {$import->updated} updated, {$import->skipped} skipped.";

        return redirect()->route('brands.index')->with('success', $message);
    }

    // Download Sample
    public function downloadSample()
    {
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="brand_sample.csv"'];

        $columns = ['brand'];
        $example = ['HP'];

        $callback = function () use ($columns, $example) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, $example);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Export
    public function export()
    {
        $brands = Brand::latest()->get();

        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="brands_export_'.now()->format('Ymd_His').'.csv"'];

        $callback = function () use ($brands) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['brand', 'created_at']);
            foreach ($brands as $b) {
                fputcsv($file, [$b->brand_name, $b->created_at->format('d/m/Y')]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
