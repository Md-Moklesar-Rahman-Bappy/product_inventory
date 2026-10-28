# Upgrade Guide

## Before Upgrading
1. **Back up the database** (see `BACKUP_AND_RESTORE.md`).
2. **Back up storage files** (`storage/app/public` and `public/storage`).
3. **Back up `.env`** (after removing secrets from any release package).
4. Put the application in maintenance mode if needed:
   ```bash
   php artisan down
   ```

## Upgrade Steps
1. Download the new release archive (`product-inventory-upgrade.zip` or `product-inventory-clean-install.zip` for fresh installs).
2. Verify archive checksums (`SHA256SUMS.txt`).
3. Extract over the existing application (excluding `.env`, `storage/app/public`, and uploaded files unless instructed).
4. Install dependencies:
   ```bash
   composer install --prefer-dist --no-dev --optimize-autoloader
   ```
5. Build frontend assets (if applicable):
   ```bash
   npm ci && npm run build
   ```
6. Run non-destructive migrations:
   ```bash
   php artisan migrate --force
   ```
7. Clear and rebuild caches:
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```
8. Restart queue workers (if applicable).
9. Verify health (`php artisan about`, `php artisan route:list`).
10. Test import/export with a sample file, including Bangla text.

## Charset Migration Warnings
- The `2026_10_28_135854_convert_unicode_charset.php` migration converts relevant text columns to `utf8mb4`.
- **Rollback limitation**: Changing charset/collation cannot be fully reversed without risk to existing Unicode data. Plan backups accordingly.
- Existing data stored as literal `?` (question marks) from previous encoding errors **cannot be reconstructed automatically**. Document this clearly to users.

## Existing Question-Mark Data Limitation
- Any product, category, brand, or model text that was previously saved as `????` due to incorrect encoding is lost permanently.
- After this upgrade, new data will be preserved correctly.
- Users must re-enter or restore affected records from a pre-corruption backup.
