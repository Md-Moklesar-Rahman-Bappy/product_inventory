<?php

namespace App\Http\Controllers;

use App\Exports\CategoryProductExport;
use App\Imports\CategoryImport;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query()->withCount('products');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('category_name', 'like', "%{$search}%");
        }

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
            '<span class="text-success fw-bold">Created</span> category: <strong>'.$category->category_name.'</strong>'
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
            'category_name' => 'required|string|max:255|unique:categories,category_name,'.$id,
        ]);

        $category = Category::withTrashed()->findOrFail($id);
        $category->update($request->only('category_name'));

        ActivityLogController::logAction(
            'update',
            'Category',
            $category->id,
            '<span class="text-primary fw-bold">Updated</span> category: <strong>'.$category->category_name.'</strong>'
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
            '<span class="text-danger fw-bold">Archived</span> category: <strong>'.$categoryName.'</strong>'
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
            '<span class="text-success fw-bold">Restored</span> category: <strong>'.$category->category_name.'</strong>'
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
            '<span class="text-danger fw-bold">Permanently deleted</span> category: <strong>'.$categoryName.'</strong>'
        );

        return redirect()->route('categories.index')
            ->with('success', '❌ Category permanently deleted.');
    }

    public function products(Request $request, $id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        $query = Product::where('category_id', $id)->with(['brand', 'model'])->orderBy('created_at', 'desc');

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
        $filename = 'products_'.Str::slug($category->category_name).'_'.now()->format('Ymd_His').'.xlsx';

        return Excel::download(new CategoryProductExport($categoryId), $filename);
    }

    // Import
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:2048',
        ]);

        $import = new CategoryImport;
        Excel::import($import, $request->file('file'));

        $message = "Import completed: {$import->created} created, {$import->updated} updated, {$import->skipped} skipped.";

        return redirect()->route('categories.index')->with('success', $message);
    }

    // Download Sample
    public function downloadSample()
    {
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="category_sample.csv"'];

        $columns = ['category'];
        $example = ['Laptop'];

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
        $categories = Category::latest()->get();

        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="categories_export_'.now()->format('Ymd_His').'.csv"'];

        $callback = function () use ($categories) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['category', 'created_at']);
            foreach ($categories as $c) {
                fputcsv($file, [$c->category_name, $c->created_at->format('d/m/Y')]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
