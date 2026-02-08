<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Exports\CategoryProductExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\ActivityLogController;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('show_trashed')) {
            $query->onlyTrashed();
        }

        $categories = $query->latest()->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name',
        ]);

        $category = Category::create($request->only('category_name'));

        ActivityLogController::logAction(
            'create',
            'Category',
            $category->id,
            '<span class="text-success fw-bold">Created</span> category: <strong>' . $category->category_name . '</strong>'
        );

        return redirect()->route('categories.index')
            ->with('success', '✅ Category created successfully.');
    }

    public function show(string $id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        return view('categories.show', compact('category'));
    }

    public function edit(string $id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $id,
        ]);

        $category = Category::withTrashed()->findOrFail($id);
        $category->update($request->only('category_name'));

        ActivityLogController::logAction(
            'update',
            'Category',
            $category->id,
            '<span class="text-primary fw-bold">Updated</span> category: <strong>' . $category->category_name . '</strong>'
        );

        return redirect()->route('categories.index')
            ->with('success', '✏️ Category updated successfully.');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $categoryName = $category->category_name;
        $category->delete();

        ActivityLogController::logAction(
            'delete',
            'Category',
            $id,
            '<span class="text-danger fw-bold">Archived</span> category: <strong>' . $categoryName . '</strong>'
        );

        return redirect()->route('categories.index')
            ->with('success', '🗑️ Category archived successfully.');
    }

    public function restore(string $id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();

        ActivityLogController::logAction(
            'restore',
            'Category',
            $id,
            '<span class="text-success fw-bold">Restored</span> category: <strong>' . $category->category_name . '</strong>'
        );

        return redirect()->route('categories.index')
            ->with('success', '♻️ Category restored successfully.');
    }

    public function forceDelete(string $id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $categoryName = $category->category_name;
        $category->forceDelete();

        ActivityLogController::logAction(
            'force_delete',
            'Category',
            $id,
            '<span class="text-danger fw-bold">Permanently deleted</span> category: <strong>' . $categoryName . '</strong>'
        );

        return redirect()->route('categories.index')
            ->with('success', '❌ Category permanently deleted.');
    }

    public function products(Request $request, $id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        $query = Product::where('category_id', $id)->with(['brand', 'model']);

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('serial_no', 'like', "%{$searchTerm}%")
                  ->orWhere('project_serial_no', 'like', "%{$searchTerm}%");
            });
        }

        $products = $query->paginate(20)->appends($request->only('search'));

        return view('categories.products', compact('category', 'products'));
    }

    public function exportCategoryProducts($categoryId)
    {
        $category = Category::withTrashed()->findOrFail($categoryId);
        $filename = 'products_' . Str::slug($category->category_name) . '_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new CategoryProductExport($categoryId), $filename);
    }
}
