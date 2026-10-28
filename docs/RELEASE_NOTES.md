# Release Notes — Fix / Unicode / Import / Export

## Changes
- **Position / Location terminology standardized**
  - Internal field: `position`
  - User-facing label: `Position`
  - Forms updated (create / edit)
- **Position numeric-zero issue fixed**
  - Root cause: `ProductImport` converted `position` to `(int)`, destroying text.
  - Fix: `trim((string) $row['position'])` applied in import; exports use text mapping.
- **Bangla Unicode support corrected**
  - Database charset verified (`utf8mb4` / `utf8mb4_unicode_ci`).
  - Import preserves Bangla in all text fields.
  - CSV exports include UTF-8 BOM.
  - XLSX exports use native Unicode.
- **Product import corrected**
  - Canonical 12 headings enforced.
  - Empty optional fields do not shift columns.
  - Date formats documented (`d/m/Y`, `m/d/Y`, `Y-m-d`).
  - `warranty_end` validated against `warranty_start`.
  - Duplicate `serial_no` and `project_serial_no` handled.
- **Product export alignment corrected**
  - Central mapping: `App\Services\ProductRowMapper`
  - All product exports (`ProductExport`, `CategoryProductExport`, `BrandProductExport`, `AssetModelProductExport`, `ProductCategorySheet`) use the same mapping.
- **Category / Brand / Model product exports corrected**
  - Headings and column order standardized to canonical 12 columns.
  - Price no longer prefixed with currency symbol in exports.
- **Sample XLSX improved**
  - Professional formatting (frozen header, column widths, text formatting for serial numbers, consistent date format, header style).
  - Includes English and Bangla example rows.
  - Includes instruction sheet.
- **User-facing validation improved**
  - Clear error messages for missing headings, invalid price, invalid dates, duplicate serial numbers, unknown lookup values.
  - No stack traces exposed to users.
- **Tests added**
  - Regression tests cover headings, alignment, position preservation, Bangla survival, authorization, and sample download.
- **Documentation added**
  - `docs/USER_GUIDE.md`
  - `docs/IMPORT_TEMPLATE_GUIDE.md`
  - `docs/INSTALLATION.md`
  - `docs/UPGRADE.md`
  - `docs/BACKUP_AND_RESTORE.md`
  - `docs/TROUBLESHOOTING.md`
  - `docs/RELEASE_CHECKLIST.md`
  - `docs/TECHNICAL_IMPORT_EXPORT.md`

## Database Migration
- `database/migrations/2026_10_28_135854_convert_unicode_charset.php`
- Converts `products`, `categories`, `brands`, `asset_models` text columns to `utf8mb4` with `utf8mb4_unicode_ci`.
- **Rollback limitation**: charset/collation changes are not safely reversible; backups required before migration.

## Upgrade Warnings
- Back up database before applying charset migration.
- Existing text already stored as literal `?` cannot be reconstructed automatically.
- Position values previously saved as `0` (numeric) must be corrected manually.

## Security Findings (Fixed / Verified)
- Import authorization preserved (`auth` + `isAdmin`).
- File MIME validation (`mimes:xlsx,xls,csv`) preserved.
- File size limit (`max:2048`) preserved.
- No mass assignment vulnerabilities added.
- No SQL injection introduced.
- No secrets added to source.
- No `.env` included in release archive.
- Error details not exposed to users (`APP_DEBUG=false` in `.env`).
