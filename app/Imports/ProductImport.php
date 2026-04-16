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

    public $errorMessage = '';

    private const MAX_PRODUCT_NAME_LENGTH = 255;

    private const MAX_TEXT_FIELD_LENGTH = 1000;

    private const MAX_PRICE = 999999999.99;

    private const MIN_YEAR = 1990;

    private const MAX_YEAR = 2099;

    public function onError(\Throwable $e)
    {
        $this->errorMessage = $e->getMessage();
        \Log::error('Product Import Error: '.$e->getMessage(), [
            'trace' => $e->getTraceAsString(),
        ]);
    }

    private function skipRow(&$row, $reason)
    {
        $this->skipped++;
        $row['skip_reason'] = $reason;
        $this->skippedRows[] = $row;
    }

    private function validateFieldLength($value, $maxLength, $fieldName, &$row)
    {
        if (mb_strlen($value) > $maxLength) {
            $this->skipRow($row, "{$fieldName} exceeds maximum length ({$maxLength} characters)");

            return false;
        }

        return true;
    }

    private function validatePrice($price, &$row)
    {
        $priceNum = (float) $price;

        if ($priceNum < 0) {
            $this->skipRow($row, 'Price cannot be negative');

            return false;
        }

        if ($priceNum > self::MAX_PRICE) {
            $this->skipRow($row, 'Price exceeds maximum allowed value');

            return false;
        }

        return true;
    }

    private function validateDateRange($date, $fieldName, &$row)
    {
        if (empty($date)) {
            return true;
        }

        $carbonDate = Carbon::parse($date);

        if ($carbonDate->year < self::MIN_YEAR || $carbonDate->year > self::MAX_YEAR) {
            $this->skipRow($row, "{$fieldName} date must be between ".self::MIN_YEAR.' and '.self::MAX_YEAR);

            return false;
        }

        return true;
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
                $this->skipRow($row, "Invalid {$field} date format");

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
            $this->skipRow($row, "Invalid {$field} date format");

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

        if (! $this->validateFieldLength($row['product_name'], self::MAX_PRODUCT_NAME_LENGTH, 'Product name', $row)) {
            return null;
        }

        if (! empty($row['user_description']) && ! $this->validateFieldLength($row['user_description'], self::MAX_TEXT_FIELD_LENGTH, 'User description', $row)) {
            return null;
        }

        if (! empty($row['remarks']) && ! $this->validateFieldLength($row['remarks'], self::MAX_TEXT_FIELD_LENGTH, 'Remarks', $row)) {
            return null;
        }

        $price = isset($row['price']) ? preg_replace('/[^0-9.]/', '', $row['price']) : 0;

        if (! $this->validatePrice($price, $row)) {
            return null;
        }

        $warrantyStart = $this->normalizeDate($row['warranty_start'] ?? null, $row, 'warranty_start');
        $warrantyEnd = $this->normalizeDate($row['warranty_end'] ?? null, $row, 'warranty_end');

        if (! $this->validateDateRange($warrantyStart, 'Warranty start', $row)) {
            return null;
        }

        if (! $this->validateDateRange($warrantyEnd, 'Warranty end', $row)) {
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

        if ($existingProduct) {
            $existingProduct->update([
                'product_name' => substr($row['product_name'], 0, self::MAX_PRODUCT_NAME_LENGTH),
                'price' => (float) $price,
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'model_id' => $modelId,
                'project_serial_no' => $row['project_serial_no'] ?? null,
                'position' => ! empty($row['position']) ? (int) $row['position'] : null,
                'user_description' => substr($row['user_description'] ?? null, 0, self::MAX_TEXT_FIELD_LENGTH),
                'remarks' => substr($row['remarks'] ?? null, 0, self::MAX_TEXT_FIELD_LENGTH),
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
            'product_name' => substr($row['product_name'], 0, self::MAX_PRODUCT_NAME_LENGTH),
            'price' => (float) $price,
            'category_id' => $categoryId,
            'brand_id' => $brandId,
            'model_id' => $modelId,
            'serial_no' => $row['serial_no'],
            'project_serial_no' => $row['project_serial_no'] ?? null,
            'position' => ! empty($row['position']) ? (int) $row['position'] : null,
            'user_description' => substr($row['user_description'] ?? null, 0, self::MAX_TEXT_FIELD_LENGTH),
            'remarks' => substr($row['remarks'] ?? null, 0, self::MAX_TEXT_FIELD_LENGTH),
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
