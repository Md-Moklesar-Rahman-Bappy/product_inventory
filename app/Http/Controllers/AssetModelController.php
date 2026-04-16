<?php

namespace App\Http\Controllers;

use App\Imports\AssetModelImport;
use App\Models\AssetModel;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AssetModelController extends Controller
{
    public function index(Request $request)
    {
        $query = AssetModel::query()->withCount('products');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('model_name', 'like', "%{$search}%");
        }

        $models = $query->latest()->paginate(10);
        $trashedModels = AssetModel::onlyTrashed()->paginate(5);

        return view('models.index', compact('models', 'trashedModels'));
    }

    public function create()
    {
        return view('models.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'model_name' => 'required|string|max:255|unique:asset_models,model_name',
        ]);

        $model = AssetModel::create($validated);

        ActivityLogController::logAction(
            'create',
            'Model',
            $model->id,
            '<span class="text-success fw-bold">Created</span> model: <strong>'.$model->model_name.'</strong>'
        );

        return redirect()->route('models.index')
            ->with('success', '✅ Model created successfully.');
    }

    public function show($id)
    {
        $model = AssetModel::withTrashed()->findOrFail($id);

        return view('models.show', compact('model'));
    }

    public function edit($id)
    {
        $model = AssetModel::withTrashed()->findOrFail($id);

        return view('models.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'model_name' => 'required|string|max:255|unique:asset_models,model_name,'.$id,
        ]);

        $model = AssetModel::withTrashed()->findOrFail($id);
        $model->update($validated);

        ActivityLogController::logAction(
            'update',
            'Model',
            $model->id,
            '<span class="text-primary fw-bold">Updated</span> model: <strong>'.$model->model_name.'</strong>'
        );

        return redirect()->route('models.index')
            ->with('success', '✏️ Model updated successfully.');
    }

    public function destroy($id)
    {
        $model = AssetModel::findOrFail($id);
        $modelName = $model->model_name;
        $model->delete();

        ActivityLogController::logAction(
            'delete',
            'Model',
            $id,
            '<span class="text-danger fw-bold">Archived</span> model: <strong>'.$modelName.'</strong>'
        );

        return redirect()->route('models.index')
            ->with('success', '🗑️ Model archived successfully.');
    }

    public function restore($id)
    {
        $model = AssetModel::onlyTrashed()->findOrFail($id);
        $model->restore();

        ActivityLogController::logAction(
            'restore',
            'Model',
            $id,
            '<span class="text-success fw-bold">Restored</span> model: <strong>'.$model->model_name.'</strong>'
        );

        return redirect()->route('models.index')
            ->with('success', '♻️ Model restored successfully.');
    }

    public function forceDelete($id)
    {
        $model = AssetModel::onlyTrashed()->findOrFail($id);
        $modelName = $model->model_name;
        $model->forceDelete();

        ActivityLogController::logAction(
            'force_delete',
            'Model',
            $id,
            '<span class="text-danger fw-bold">Permanently deleted</span> model: <strong>'.$modelName.'</strong>'
        );

        return redirect()->route('models.index')
            ->with('success', '❌ Model permanently deleted.');
    }

    public function products($id)
    {
        $model = AssetModel::withTrashed()->findOrFail($id);

        $query = Product::with(['brand', 'category'])
            ->where('model_id', $model->id)
            ->orderBy('created_at', 'desc');

        if (request()->has('search')) {
            $query->where('serial_no', 'like', '%'.request('search').'%');
        }

        $products = $query->paginate(10);

        return view('models.products', compact('model', 'products'));
    }

    // Import
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:2048',
        ]);

        $import = new AssetModelImport;
        Excel::import($import, $request->file('file'));

        $message = "Import completed: {$import->created} created, {$import->updated} updated, {$import->skipped} skipped.";

        return redirect()->route('models.index')->with('success', $message);
    }

    // Download Sample
    public function downloadSample()
    {
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="model_sample.csv"'];

        $columns = ['model'];
        $example = ['ThinkPad X1'];

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
        $models = AssetModel::latest()->get();

        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="models_export_'.now()->format('Ymd_His').'.csv"'];

        $callback = function () use ($models) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['model', 'created_at']);
            foreach ($models as $m) {
                fputcsv($file, [$m->model_name, $m->created_at->format('d/m/Y')]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
