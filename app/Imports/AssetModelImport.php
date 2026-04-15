<?php

namespace App\Imports;

use App\Http\Controllers\ActivityLogController;
use App\Models\AssetModel;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssetModelImport implements SkipsOnError, ToModel, WithHeadingRow
{
    use SkipsErrors;

    public $created = 0;

    public $updated = 0;

    public $skipped = 0;

    public $skippedRows = [];

    private function skipRow(&$row, $reason)
    {
        $this->skipped++;
        $row['skip_reason'] = $reason;
        $this->skippedRows[] = $row;
    }

    public function model(array $row)
    {
        $modelName = $row['model'] ?? $row['model_name'] ?? null;

        if (empty($modelName)) {
            $this->skipRow($row, 'Missing model');

            return null;
        }

        $modelName = trim($modelName);

        $existing = AssetModel::withTrashed()
            ->where('model_name', $modelName)
            ->first();

        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
            }
            $existing->update(['model_name' => $modelName]);
            $this->updated++;

            ActivityLogController::logAction(
                'update',
                'Model',
                $existing->id,
                '<span class="text-primary fw-bold">Updated</span> model via Excel: <strong>'.$existing->model_name.'</strong>'
            );

            return null;
        }

        $model = AssetModel::create(['model_name' => $modelName]);
        $this->created++;

        ActivityLogController::logAction(
            'create',
            'Model',
            $model->id,
            '<span class="text-success fw-bold">Created</span> model via Excel: <strong>'.$model->model_name.'</strong>'
        );

        return null;
    }
}
