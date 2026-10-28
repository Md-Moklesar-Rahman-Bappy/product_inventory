# Release Checklist

## Automated Tests
- [ ] `php artisan test` passes.
- [ ] Regression tests cover position text preservation, Bangla import/export, and column alignment.

## Static Analysis
- [ ] `vendor/bin/pint --test` passes (formatting).
- [ ] No syntax errors in changed files.

## Code Formatting
- [ ] `vendor/bin/pint` applied to changed PHP files.

## Composer Security Audit
- [ ] `composer audit` reports no critical vulnerabilities in used packages.

## Frontend Build
- [ ] `npm ci` and `npm run build` complete (if frontend assets used).

## Migration Review
- [ ] All migrations are safe and reversible where possible.
- [ ] `charset/collation` migration includes rollback warning.
- [ ] Existing data preserved.

## Backup Verification
- [ ] Database backup command tested with placeholders.
- [ ] Storage backup verified.
- [ ] `.env` not included in release archive.

## Fresh Installation Test
- [ ] `.env.example` creates a working `.env`.
- [ ] `php artisan migrate` runs from empty database.
- [ ] `php artisan key:generate` works.
- [ ] First admin can be created.
- [ ] Login works.
- [ ] Product creation works.
- [ ] Bangla text can be saved and retrieved.
- [ ] XLSX sample download works.
- [ ] Import/export functions work.

## Upgrade Test
- [ ] Non-destructive migrations run successfully.
- [ ] Cache commands clear properly.
- [ ] Existing products with Bangla text remain intact.

## Import Test
- [ ] English-only import works.
- [ ] Bangla-only import works.
- [ ] Mixed Bangla and English import works.
- [ ] Empty optional fields remain blank (not `0` or shifted).
- [ ] Invalid dates produce clear row-level errors.
- [ ] Duplicate serial numbers handled properly.

## Export Test
- [ ] `ProductExport` headings match canonical order.
- [ ] `CategoryProductExport` uses canonical 12 columns.
- [ ] `BrandProductExport` uses canonical 12 columns.
- [ ] `AssetModelProductExport` uses canonical 12 columns.
- [ ] Position exports as text (`0` never appears for text values).
- [ ] Blank remarks keep warranty columns aligned.

## Bangla Unicode Test
- [ ] Bangla `position` survives form submission, database retrieval, and export.
- [ ] Bangla `user_description` and `remarks` preserved.
- [ ] No `????` in exported `.xlsx` or `.csv`.

## Authorization Test
- [ ] Unauthorized users cannot access import/export routes (`403` returned).
- [ ] Admin-only routes protected by `isAdmin` middleware.

## Secret Scan
- [ ] No `.env` file in release archive.
- [ ] No `APP_KEY`, `DB_PASSWORD`, `LICENSE_API_KEY`, or OAuth secrets included.
- [ ] `.gitignore` excludes `.env`, `storage/logs/`, `node_modules/`, `vendor/` (optional), `.idea/`.

## Archive Content Review
- [ ] Archive named clearly (e.g., `product-inventory-clean-install.zip`).
- [ ] Contains source, migrations, tests, docs, `.env.example`, sample generation route/class.
- [ ] Does not contain `.env`, production dumps, real user/product data, logs, or temporary files.

## Rollback Verification
- [ ] Documented rollback steps are present in `UPGRADE.md`.
- [ ] Database backup exists before migration.
- [ ] Charset rollback limitations clearly documented.
