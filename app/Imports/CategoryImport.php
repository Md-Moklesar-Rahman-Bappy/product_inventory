<?php

namespace App\Imports;

use App\Http\Controllers\ActivityLogController;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements SkipsOnError, ToModel, WithHeadingRow
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
        $categoryName = $row['category'] ?? $row['category_name'] ?? null;

        if (empty($categoryName)) {
            $this->skipRow($row, 'Missing category');

            return null;
        }

        $categoryName = trim($categoryName);

        $existing = Category::withTrashed()
            ->where('category_name', $categoryName)
            ->first();

        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
            }
            $existing->update(['category_name' => $categoryName]);
            $this->updated++;

            ActivityLogController::logAction(
                'update',
                'Category',
                $existing->id,
                '<span class="text-primary fw-bold">Updated</span> category via Excel: <strong>'.$existing->category_name.'</strong>'
            );

            return null;
        }

        $category = Category::create(['category_name' => $categoryName]);
        $this->created++;

        ActivityLogController::logAction(
            'create',
            'Category',
            $category->id,
            '<span class="text-success fw-bold">Created</span> category via Excel: <strong>'.$category->category_name.'</strong>'
        );

        return null;
    }
}
