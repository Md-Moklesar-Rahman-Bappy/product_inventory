<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetModel;
use App\Models\Product;
use App\Http\Controllers\ActivityLogController;

class AssetModelController extends Controller
{
    public function index()
    {
        $models = AssetModel::latest()->paginate(10); // Active models
        $trashedModels = AssetModel::onlyTrashed()->paginate(5); // Recycle bin

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
            '<span class="text-success fw-bold">Created</span> model: <strong>' . $model->model_name . '</strong>'
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
            'model_name' => 'required|string|max:255|unique:asset_models,model_name,' . $id,
        ]);

        $model = AssetModel::withTrashed()->findOrFail($id);
        $model->update($validated);

        ActivityLogController::logAction(
            'update',
            'Model',
            $model->id,
            '<span class="text-primary fw-bold">Updated</span> model: <strong>' . $model->model_name . '</strong>'
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
            '<span class="text-danger fw-bold">Archived</span> model: <strong>' . $modelName . '</strong>'
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
            '<span class="text-success fw-bold">Restored</span> model: <strong>' . $model->model_name . '</strong>'
        );

        return redirect()->route('models.index')
            ->with('success', '♻️ Model restored successfully.');
    }

    // Optional: Permanently delete a model
    /*
    public function forceDelete($id)
    {
        $model = AssetModel::onlyTrashed()->findOrFail($id);
        $modelName = $model->model_name;
        $model->forceDelete();

        ActivityLogController::logAction(
            'force_delete',
            'Model',
            $id,
            '<span class="text-danger fw-bold">Permanently deleted</span> model: <strong>' . $modelName . '</strong>'
        );

        return redirect()->route('models.index')
            ->with('success', '❌ Model permanently deleted.');
    }
    */

    public function products($id)
    {
        $model = AssetModel::withTrashed()->findOrFail($id);

        $query = Product::with(['brand', 'category'])
            ->where('model_id', $model->id);

        if (request()->has('search')) {
            $query->where('serial_no', 'like', '%' . request('search') . '%');
        }

        $products = $query->paginate(10);

        return view('models.products', compact('model', 'products'));
    }
}
