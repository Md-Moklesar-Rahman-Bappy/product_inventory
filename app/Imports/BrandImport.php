<?php

namespace App\Imports;

use App\Http\Controllers\ActivityLogController;
use App\Models\Brand;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BrandImport implements SkipsOnError, ToModel, WithHeadingRow
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
        $brandName = $row['brand'] ?? $row['brand_name'] ?? null;

        if (empty($brandName)) {
            $this->skipRow($row, 'Missing brand');

            return null;
        }

        $brandName = trim($brandName);

        $existing = Brand::withTrashed()
            ->where('brand_name', $brandName)
            ->first();

        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
            }
            $existing->update(['brand_name' => $brandName]);
            $this->updated++;

            ActivityLogController::logAction(
                'update',
                'Brand',
                $existing->id,
                '<span class="text-primary fw-bold">Updated</span> brand via Excel: <strong>'.$existing->brand_name.'</strong>'
            );

            return null;
        }

        $brand = Brand::create(['brand_name' => $brandName]);
        $this->created++;

        ActivityLogController::logAction(
            'create',
            'Brand',
            $brand->id,
            '<span class="text-success fw-bold">Created</span> brand via Excel: <strong>'.$brand->brand_name.'</strong>'
        );

        return null;
    }
}
