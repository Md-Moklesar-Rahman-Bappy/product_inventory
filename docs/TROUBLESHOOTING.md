# Troubleshooting

## Bangla Exported as Question Marks (`????`)
- Cause: File saved with wrong encoding or database/table charset is not `utf8mb4`.
- Fix:
  1. Verify database uses `utf8mb4` (see `INSTALLATION.md`).
  2. Use `.xlsx` for exports (recommended).
  3. If using CSV, save with UTF-8 BOM.

## Bangla Imported as Question Marks
- Cause: CSV without BOM, spreadsheet saved in non-UTF-8 encoding, or database connection charset misconfigured.
- Fix:
  1. Save import file as `.xlsx`.
  2. Verify `.env` has `DB_CHARSET=utf8mb4` and `DB_COLLATION=utf8mb4_unicode_ci`.
  3. Run `php artisan config:clear` after changing `.env`.

## CSV versus XLSX Behavior
- `.xlsx` preserves Unicode reliably and handles dates and text formatting correctly.
- `.csv` requires explicit UTF-8 BOM for Bangla support in Excel.
- If CSV import fails with encoding errors, switch to `.xlsx`.

## Position Exported as `0`
- Root cause: Import or export mapped `position` as a numeric value (`(int)`), destroying text.
- Fix applied: `position` is handled as `trim((string) $value)` in import and mapped as text in exports.
- If existing records show `0`, the text was lost during a previous import; enter the correct text value manually.

## Warranty Dates in Wrong Perceived Column
- Cause: Incorrect column mapping in export files.
- Fix: All exports now use the centralized `ProductRowMapper`, which enforces the exact 12-column canonical order.

## Empty Remarks Cells
- Blank `remarks` must produce an empty cell, not shift `warranty_start` into the remarks column.
- The centralized mapping ensures `remarks` is always the 10th column and `warranty_start` the 11th.

## Excel Displaying Serial Numbers Incorrectly
- Excel may interpret long numeric-like strings as numbers or dates.
- The export formats `serial_no` and `project_serial_no` as text strings.
- When opening CSV, import using `Data > Get Data > From Text/CSV` and set column format to **Text** for serial columns.

## Unknown Heading Errors
- The import requires exact heading names (case-insensitive match by `WithHeadingRow` but exact spelling preferred).
- Use the headings listed in `docs/IMPORT_TEMPLATE_GUIDE.md`.
- Unknown headings are ignored; missing required headings cause validation errors.

## Duplicate Value Errors
- `serial_no` and `project_serial_no` must be unique.
- The import reports duplicates at row level. Fix the duplicate value and re-import.

## 419 Errors (CSRF)
- Ensure the session cookie is set correctly (`SESSION_DOMAIN` in `.env`).
- Clear cookies or try in an incognito window.
- Verify `SESSION_DRIVER` and session path are writable.

## 403 Errors (Forbidden)
- Check user role: import/export and product management require `isAdmin`.
- Verify the user is active (`auth` middleware).

## 422 Validation Errors
- Check required fields (`product_name`, `price`, `serial_no`, etc.).
- Verify `warranty_end` is not earlier than `warranty_start`.
- Ensure price is a non-negative number.

## 500 Errors Without Exposing Internals
- Check `storage/logs/laravel.log` for the full error message (not exposed to users).
- Common causes: missing database table, invalid column type, missing package (`maatwebsite/excel`), or incorrect file permissions.
- Ensure `APP_DEBUG=false` in production so users do not see stack traces.

## File Permission Errors
- Ensure web server has read/write access to:
  - `storage/logs/`
  - `storage/framework/`
  - `public/storage/`
- Fix with:
  ```bash
  chmod -R 775 storage bootstrap/cache public/storage
  ```

## Cache Issues
- After updates, always run:
  ```bash
  php artisan config:clear
  php artisan view:clear
  php artisan route:clear
  ```

## Database Collation Verification
Run:
```sql
SELECT DEFAULT_CHARACTER_SET_NAME, DEFAULT_COLLATION_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME='product_inventory';
SELECT TABLE_COLLATION FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME='products';
SELECT COLUMN_NAME, COLLATION_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='products';
```
Expected: `utf8mb4` / `utf8mb4_unicode_ci`.

## Log Location
Based on the real project configuration (`config/logging.php`):
- Default stack channel: `stack` (`single` file in `storage/logs/laravel.log`).
- For production with `APP_DEBUG=false`, errors are logged but not shown to users.
