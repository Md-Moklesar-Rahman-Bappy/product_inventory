<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\AssetModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ProductImport implements ToModel, WithHeadingRow
{
    use Importable;

    public $imported = 0;
    public $skipped = 0;
    public $skippedRows = [];

    /**
     * Helper to mark a row as skipped.
     */
    private function skipRow(&$row, $reason)
    {
        $this->skipped++;
        $row['skip_reason'] = $reason;
        $this->skippedRows[] = $row;
        \Log::warning("Skipped row: {$reason}", $row);
    }

    /**
     * Normalize and validate date input.
     * Accepts Excel serials, d/m/Y, m/d/Y, Y-m-d, falls back to strtotime.
     */
    private function normalizeDate($value, &$row, $field)
    {
        if (empty($value)) return null;

        // Handle Excel numeric serial dates
        if (is_numeric($value)) {
            try {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($value))
                    ->format('Y-m-d');
            } catch (\Exception $e) {
                $this->skipRow($row, "Invalid {$field} Excel serial date");
                return null;
            }
        }

        // Try multiple text formats
        $formats = ['d/m/Y', 'm/d/Y', 'Y-m-d'];
        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, trim($value))->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }
        }

        // Fallback: strtotime
        $timestamp = strtotime($value);
        if ($timestamp === false) {
            $this->skipRow($row, "Invalid {$field} date format");
            return null;
        }
        return date('Y-m-d', $timestamp);
    }

    public function model(array $row)
    {
        // Ensure serials are uppercase
        if (!empty($row['serial_no'])) {
            $row['serial_no'] = strtoupper($row['serial_no']);
        }
        if (!empty($row['project_serial_no'])) {
            $row['project_serial_no'] = strtoupper($row['project_serial_no']);
        }

        // Skip if essential fields are missing
        if (empty($row['product_name']) || empty($row['serial_no'])) {
            $this->skipRow($row, 'Missing required fields');
            return null;
        }

        // Skip if duplicate serial_no exists
        if (Product::where('serial_no', $row['serial_no'])->exists()) {
            $this->skipRow($row, 'Duplicate serial_no');
            return null;
        }

        // Skip if duplicate project_serial_no exists
        if (!empty($row['project_serial_no']) &&
            Product::where('project_serial_no', $row['project_serial_no'])->exists()) {
            $this->skipRow($row, 'Duplicate project_serial_no');
            return null;
        }

        // Auto-create or fetch category, brand, model
        $categoryId = !empty($row['category'])
            ? Category::firstOrCreate(['category_name' => trim($row['category'])])->id
            : null;

        $brandId = !empty($row['brand'])
            ? Brand::firstOrCreate(['brand_name' => trim($row['brand'])])->id
            : null;

        $modelId = !empty($row['model'])
            ? AssetModel::firstOrCreate(['model_name' => trim($row['model'])])->id
            : null;

        // Clean price (remove symbols, keep numeric)
        $price = isset($row['price'])
            ? preg_replace('/[^0-9.\-]/', '', $row['price'])
            : 0;

        // Normalize and validate dates
        $warrantyStart = $this->normalizeDate($row['warranty_start'] ?? null, $row, 'warranty_start');
        $warrantyEnd   = $this->normalizeDate($row['warranty_end'] ?? null, $row, 'warranty_end');

        // If either date was invalid, skip the row entirely
        if (isset($row['skip_reason']) && str_contains($row['skip_reason'], 'date')) {
            return null;
        }

        $this->imported++;

        return new Product([
            'product_name'      => $row['product_name'],
            'price'             => $price,
            'category_id'       => $categoryId,
            'brand_id'          => $brandId,
            'model_id'          => $modelId,
            'serial_no'         => $row['serial_no'],
            'project_serial_no' => $row['project_serial_no'] ?? null,
            'position'          => $row['position'] ?? null,
            'user_description'  => $row['user_description'] ?? null,
            'remarks'           => $row['remarks'] ?? null,
            'warranty_start'    => $warrantyStart,
            'warranty_end'      => $warrantyEnd,
        ]);
    }
}
