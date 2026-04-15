<?php

namespace App\Imports;

use App\Http\Controllers\ActivityLogController;
use App\Models\AssetModel;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ProductImport implements SkipsOnError, ToModel, WithHeadingRow
{
    use Importable, SkipsErrors;

    public $imported = 0;

    public $created = 0;

    public $updated = 0;

    public $skipped = 0;

    public $skippedRows = [];

    protected $userId;

    public function __construct()
    {
        $this->userId = auth()->id();
    }

    private function skipRow(&$row, $reason)
    {
        $this->skipped++;
        $row['skip_reason'] = $reason;
        $this->skippedRows[] = $row;
    }

    private function normalizeDate($value, &$row, $field)
    {
        if (empty($value)) {
            return null;
        }

        if (is_numeric($value)) {
            try {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($value))
                    ->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        $formats = ['d/m/Y', 'm/d/Y', 'Y-m-d'];
        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, trim($value))->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }
        }

        $timestamp = strtotime($value);
        if ($timestamp === false) {
            return null;
        }

        return date('Y-m-d', $timestamp);
    }

    public function model(array $row)
    {
        if (! empty($row['serial_no'])) {
            $row['serial_no'] = strtoupper(trim($row['serial_no']));
        }
        if (! empty($row['project_serial_no'])) {
            $row['project_serial_no'] = strtoupper(trim($row['project_serial_no']));
        }

        if (empty($row['product_name']) || empty($row['serial_no'])) {
            $this->skipRow($row, 'Missing required fields');

            return null;
        }

        $existingProduct = Product::where('serial_no', $row['serial_no'])->first();

        $categoryId = ! empty($row['category'])
            ? Category::firstOrCreate(['category_name' => trim($row['category'])])->id
            : null;

        $brandId = ! empty($row['brand'])
            ? Brand::firstOrCreate(['brand_name' => trim($row['brand'])])->id
            : null;

        $modelId = ! empty($row['model'])
            ? AssetModel::firstOrCreate(['model_name' => trim($row['model'])])->id
            : null;

        $price = isset($row['price'])
            ? preg_replace('/[^0-9.\-]/', '', $row['price'])
            : 0;

        $warrantyStart = $this->normalizeDate($row['warranty_start'] ?? null, $row, 'warranty_start');
        $warrantyEnd = $this->normalizeDate($row['warranty_end'] ?? null, $row, 'warranty_end');

        if ($existingProduct) {
            $oldData = $existingProduct->toArray();

            $existingProduct->update([
                'product_name' => $row['product_name'],
                'price' => $price,
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'model_id' => $modelId,
                'project_serial_no' => $row['project_serial_no'] ?? null,
                'position' => $row['position'] ?? null,
                'user_description' => $row['user_description'] ?? null,
                'remarks' => $row['remarks'] ?? null,
                'warranty_start' => $warrantyStart,
                'warranty_end' => $warrantyEnd,
            ]);

            $this->updated++;
            $this->imported++;

            ActivityLogController::logAction(
                'update',
                'Product',
                $existingProduct->id,
                '<span class="text-primary fw-bold">Updated</span> product via Excel import: <strong>'.$existingProduct->product_name.'</strong><br>Serial No: <code>'.$existingProduct->serial_no.'</code>'
            );

            return null;
        }

        $product = Product::create([
            'product_name' => $row['product_name'],
            'price' => $price,
            'category_id' => $categoryId,
            'brand_id' => $brandId,
            'model_id' => $modelId,
            'serial_no' => $row['serial_no'],
            'project_serial_no' => $row['project_serial_no'] ?? null,
            'position' => $row['position'] ?? null,
            'user_description' => $row['user_description'] ?? null,
            'remarks' => $row['remarks'] ?? null,
            'warranty_start' => $warrantyStart,
            'warranty_end' => $warrantyEnd,
        ]);

        $this->created++;
        $this->imported++;

        ActivityLogController::logAction(
            'create',
            'Product',
            $product->id,
            '<span class="text-success fw-bold">Created</span> product via Excel import: <strong>'.$product->product_name.'</strong><br>Serial No: <code>'.$product->serial_no.'</code>'
        );

        return null;
    }
}
