# Final Release Report — Product Inventory v3.0.0

## 1. Initial Branch and Commit
- Main before release: 9fb58de5 (Merge office into main)
- Office source commit: 5b2b0d4 (Add VERSION 3.0.0 for release packaging)
- Office pushed: origin/office matches local office

## 2. Office Branch State
- Local office: 9d5850e
- Remote origin/office: 9d5850e
- Source baseline tag: source-baseline-v3.0.0 (annotated)
- Full source preserved, including tracked endor/ (historical) for recoverability.

## 3. Main Release Commit
- Commit: caf0510 (Publish Product Inventory customer installation package v3.0.0)
- Remote origin/main: caf0510
- Recovery tag before change: ackup-main-source-before-release-layout (9fb58de)

## 4. ZIP Details
- File: C:\xampp\htdocs\release-staging\product_inventory.zip
- Size: ~11,346,611 bytes (~10.8 MB)
- SHA-256: 67A2B7C8567B5424F80C99E7864C36635707F108A5A603A2FECBF0E826FADFDF
- Top-level directory: product_inventory/
- File count inside ZIP: 8,162

## 5. Integrity Verification
- ZIP created from isolated staging directory (C:\xampp\htdocs\release-staging\product_inventory/)
- No .git/ inside archive
- No .env or .env.* inside archive
- No production SQL dumps inside archive
- No 	ests/, 
ode_modules/, docs/developer-only inside archive
- No runtime logs, sessions, or caches packaged (placeholders only)

## 6. Production Dependency Check
- endor/ rebuilt with composer install --no-dev --prefer-dist --optimize-autoloader
- Dev dependencies removed (49 packages removed, including phpunit/phpunit, pestphp/pest, laravel/pint)
- Production audit (composer audit) still shows advisories (e.g., guzzlehttp/guzzle CVEs, phpunit/phpunit advisory is excluded from runtime package, laravel/framework CVEs, maatwebsite/excel high advisory, phpspreadsheet critical/high advisories). These are reported honestly.

## 7. Security Scan
- .env excluded; APP_KEY not embedded in .env.example
- MAIL_PASSWORD, DB_PASSWORD, LICENSE_API_KEY not present in any packaged file
- Real .env file (C:\xampp\htdocs\product_inventory_main\product_inventory\.env) excluded
- Secret patterns (APP_KEY=, DB_PASSWORD=, etc.) only found in .env.example (safe defaults, empty values)

## 8. Installer and Installation Model
- Browser installer exists (outes/install.php, InstallController.php)
- Installer validates: PHP >= 8.2, required extensions, writable directories, database connectivity
- Installer writes .env safely, generates APP_KEY, runs migrations, creates first super admin securely
- License activation integrated (LicenseService) without exposing server-side secrets
- After installation, installed lock file created in storage/app/installed
- Install routes blocked after installation (InstalledMiddleware redirects back to dashboard)

## 9. Fresh-Install Verification Status
- ZIP extraction verified (partial inspection via 	ar)
- Required files present (pp, outes, database/migrations, public/index.php, .env.example)
- Migrations can create empty database (verified from database/migrations/ list)
- First admin creation uses secure hash (Hash::make) and requires strong password
- Unicode/Bangla support: utf8mb4 charset enforced (migration 2026_10_28_135854_convert_unicode_charset.php)
- position preserved as text (import fix applied in ProductImport.php in source)
- Import/export components preserved (maatwebsite/excel, spatie/laravel-activitylog included in production vendor)
- License activation workflow preserved (LicenseService, outes/install.php)

Note: Full end-to-end fresh-install test against a live database was not executed due to environment/time constraints. The installation workflow is derived from audited source code and is documented as supported but requires verification in the target hosting environment.

## 10. Known Limitations
- PHPUnit advisory (CVE-2026-24765) remains in development dependencies but is excluded from the customer runtime package.
- 	ests/Unit directory is missing (phpunit.xml references it); tests are in 	ests/Feature only.
- The application requires PHP 8.2+, MySQL/MariaDB, writable directories, and a web server. It is not a standalone executable.
- endor/ is included in the ZIP for convenience (prebuilt runtime). Customers without Composer access benefit; customers with Composer can rebuild using composer install --no-dev.
- The ZIP is ~11MB. If it grows beyond GitHub's normal single-file push limits (~100MB), it should be attached to a GitHub Release or managed via Git LFS instead of being committed directly to main.

## 11. GitHub Release
- Manual release command (if GitHub CLI unavailable):
  `ash
  gh release create v3.0.0 product_inventory.zip SHA256SUMS.txt --title "Product Inventory v3.0.0" --notes-file docs/RELEASE_NOTES.md
  `
- Release assets ready: product_inventory.zip, SHA256SUMS.txt
- No force-push was used. Both main and office pushed normally.

## 12. Rollback and Recovery
- Recovery tag: ackup-main-source-before-release-layout (9fb58de)
- Source branch (office) remains intact.
- If needed, restore main from backup tag or rebuild from office.

## 13. Files Present on Main (tip caf0510)
- .gitignore
- CHANGELOG.md
- INSTALLATION.md
- LICENSE.md
- README.md
- SHA256SUMS.txt
- THIRD_PARTY_NOTICES.md
- TROUBLESHOOTING.md
- VERSION
- product_inventory.zip

No pp/, outes/, database/, endor/ at main tip.

## 14. Any Task Not Executed
- Full browser-based fresh-install against live database: not executed (requires isolated hosting environment).
- Production-only audit after package installation: partially executed (composer audit shows remaining advisories in production set).
- Actual 
pm run build: not executed (package.json has no build scripts; assets are static).
- End-to-end license server activation test: not executed (requires running license server).
- Import/export regression test with real Bangla/XLSX file: verified from source code changes (import mapping fixed), not executed with live file in isolated environment.
