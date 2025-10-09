<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Http\Controllers\ActivityLogController;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(10); // Active brands
        $trashedBrands = Brand::onlyTrashed()->paginate(5); // Recycle bin

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
            '<span class="text-success fw-bold">Created</span> brand: <strong>' . $brand->brand_name . '</strong>'
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
            'brand_name' => 'required|string|max:255|unique:brands,brand_name,' . $id,
        ]);

        $brand = Brand::withTrashed()->findOrFail($id);
        $brand->update($request->only('brand_name'));

        ActivityLogController::logAction(
            'update',
            'Brand',
            $brand->id,
            '<span class="text-primary fw-bold">Updated</span> brand: <strong>' . $brand->brand_name . '</strong>'
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
            '<span class="text-danger fw-bold">Archived</span> brand: <strong>' . $brandName . '</strong>'
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
            '<span class="text-success fw-bold">Restored</span> brand: <strong>' . $brand->brand_name . '</strong>'
        );

        return redirect()->route('brands.index')
            ->with('success', '♻️ Brand restored successfully.');
    }

    // Optional: Permanently delete a brand
    /*
    public function forceDelete($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brandName = $brand->brand_name;
        $brand->forceDelete();

        ActivityLogController::logAction(
            'force_delete',
            'Brand',
            $id,
            '<span class="text-danger fw-bold">Permanently deleted</span> brand: <strong>' . $brandName . '</strong>'
        );

        return redirect()->route('brands.index')
            ->with('success', '❌ Brand permanently deleted.');
    }
    */

    public function products($id)
    {
        $brand = Brand::withTrashed()->findOrFail($id);

        $query = Product::with(['model', 'category'])
            ->where('brand_id', $brand->id);

        if (request()->filled('search')) {
            $query->where('serial_no', 'like', '%' . request('search') . '%');
        }

        $products = $query->paginate(10);

        return view('brands.products', compact('brand', 'products'));
    }
}
