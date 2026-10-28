# Packaging Architecture

## Customer Package (product_inventory.zip)

Contents:
- product_inventory/ (top-level directory)
- Production endor/ (built via composer install --no-dev --optimize-autoloader)
- Source code (pp/, outes/, database/ migrations and seeders)
- public/ entry point and assets
- .env.example (safe defaults, APP_DEBUG=false)
- Customer documentation
- VERSION and CHANGELOG.md

Excluded:
- .git/ directory
- .env and real environment files
- Development dependencies (phpunit/phpunit, pestphp/pest, laravel/pint)
- 	ests/ directory
- SQL dumps (product_inventory.sql, product-inventory-bug-fixes.sql)
- Runtime logs, sessions, caches
- Previous ZIP archives

## Vendor Strategy

The repository historically tracked endor/. For customer releases, we rebuild production endor/ to exclude dev packages (reducing size and removing PHPUnit development-only advisories from the runtime). After building the ZIP, we audit the installed production set (composer audit) and document any remaining advisories honestly.

## Size Consideration

If product_inventory.zip exceeds GitHub's normal single-file limit (~100MB for normal pushes), the file should be attached to a GitHub Release (not committed to main) or managed via Git LFS. The current package is ~11MB, which is well under the limit.
