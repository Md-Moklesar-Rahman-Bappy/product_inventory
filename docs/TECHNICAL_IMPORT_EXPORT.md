# Technical Import / Export Documentation

## Central Row Mapping
- Source: `App\Services\ProductRowMapper`
- Headings (canonical 12 columns):
  `product_name`, `price`, `category`, `brand`, `model`, `serial_no`, `project_serial_no`, `position`, `user_description`, `remarks`, `warranty_start`, `warranty_end`
- Mapping method: `mapRow(Product $product): array`
- Used by: all product exports (`ProductExport`, `CategoryProductExport`, `BrandProductExport`, `AssetModelProductExport`, `ProductCategorySheet`).

## Import Class Flow
- File: `App\Imports\ProductImport`
- Concerns: `ToModel`, `WithHeadingRow`, `SkipsOnError`, `Importable`, `SkipsErrors`
- Flow:
  1. Read row with headings.
  2. Trim and normalize text fields (`trim`, `strtoupper` for serial numbers).
  3. Validate lengths (`MAX_PRODUCT_NAME_LENGTH = 255`, `MAX_TEXT_FIELD_LENGTH = 1000`).
  4. Validate price (non-negative, numeric).
  5. Normalize dates (`d/m/Y`, `m/d/Y`, `Y-m-d`, numeric Excel dates).
  6. Validate warranty date range (`warranty_end` >= `warranty_start`).
  7. Look up or create relationships (`Category::firstOrCreate`, `Brand::firstOrCreate`, `AssetModel::firstOrCreate`).
  8. Check duplicates (`serial_no`, `project_serial_no`).
  9. Create or update product in a database transaction (implicitly handled by `ToModel` per row; consider wrapping in transaction for bulk imports if needed).
  10. Log actions via `ActivityLogController`.

## Export Class Flow
- Base mapping: `App\Services\ProductRowMapper`
- Query patterns use eager loading (`with(['category', 'brand', 'model'])`) to avoid N+1.
- CSV export writes UTF-8 BOM (`chr(0xEF).chr(0xBB).chr(0xBF)`) for Excel compatibility.
- XLSX exports use `FromQuery` + `WithMapping` + `WithHeadings`.

## Heading Definitions
- All exports must use `ProductRowMapper::headings()`.
- No custom headings allowed for product exports.
- For non-product entity exports (categories, brands, models), keep their own entity-specific columns.

## Validation Flow
- `ProductController::store()` validates with `required|string|max:255` etc.
- `ProductController::update()` uses similar rules with `nullable|string` for optional fields and `unique` exclusions.
- Import validation uses `validateFieldLength`, `validatePrice`, `normalizeDate`, `validateDateRange`.

## Relationship Lookup
- `category`: `Category::firstOrCreate(['category_name' => trim($value)])`
- `brand`: `Brand::firstOrCreate(['brand_name' => trim($value)])`
- `model`: `AssetModel::firstOrCreate(['model_name' => trim($value)])`
- This preserves existing behavior (auto-creation) but is documented clearly.

## Date Handling
- Storage format: `Y-m-d` (`dateTime` column).
- Import formats supported: `d/m/Y`, `m/d/Y`, `Y-m-d`, Excel numeric dates.
- Export format: `d/m/Y`.
- Invalid dates skip the row and report the error.

## Unicode Handling
- Database: `utf8mb4` charset, `utf8mb4_unicode_ci` collation.
- Import: `trim()` without stripping Bangla; `(string)` cast for `position`.
- CSV: UTF-8 BOM written.
- XLSX: native Unicode support via PHPSpreadsheet.

## Database Transaction Boundaries
- `ToModel` processes each row individually. For bulk imports, consider using `WithBatchInserts` or wrapping in a transaction manually, but the current design updates/creates per row to maintain accurate row-level error reporting.
- If a transaction failure occurs, the import catches `Throwable` and reports `errorMessage` to the user without exposing SQL details.

## Error Reporting
- Row-level errors are stored in `$this->skippedRows` with `skip_reason`.
- User-facing messages: `session()->flash('error', ...)` with a readable message.
- Technical details (`trace`, SQL) are logged to `storage/logs/laravel.log` via `\Log::error()`.

## Authorization
- Import/export routes use `Route::middleware(['auth', 'isAdmin'])`.
- Individual routes: `product.export`, `product.import`, `category.products.export`, etc.
- Unauthorized access returns a redirect or `403` based on middleware behavior.

## Extension Points
- To add a new export mapping: update `ProductRowMapper` (do not duplicate mappings in individual exports).
- To add new validation rules: extend `ProductImport` private validation methods.
- To add new relationship types: extend the lookup logic in `ProductImport::model()`.
