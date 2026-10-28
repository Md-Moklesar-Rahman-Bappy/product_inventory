# Installation Guide

## Requirements
- PHP: `^8.2`
- Laravel: `^12.0`
- Composer: `^2.8`
- Database: MySQL / MariaDB 10.4+ (tested on `10.4.32-MariaDB`)
- PHP extensions: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `json`, `fileinfo`, `gd` (optional)
- Node.js / npm (optional, for frontend assets if used)

## Database Setup
1. Create the database:
   ```sql
   CREATE DATABASE product_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Ensure the `.env` uses:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=product_inventory
   DB_USERNAME=root
   DB_PASSWORD=
   DB_CHARSET=utf8mb4
   DB_COLLATION=utf8mb4_unicode_ci
   ```

## Environment
1. Copy `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   ```
2. Generate the application key:
   ```bash
   php artisan key:generate
   ```
3. Set `APP_URL`, `DB_*`, and other variables as needed.
4. **Remove any real `.env` secrets from release packages.** Only `.env.example` should be distributed.

## Dependency Installation
```bash
composer install --prefer-dist --no-dev --optimize-autoloader
```
For development:
```bash
composer install
```

## Database Migration
```bash
php artisan migrate --force
```
Run the charset migration safely:
```bash
php artisan migrate --path=database/migrations/2026_10_28_135854_convert_unicode_charset.php
```

## Storage Link
```bash
php artisan storage:link
```

## Writable Directories
Ensure the following are writable by the web server:
- `storage/`
- `bootstrap/cache/`
- `public/storage/`

## Cache Commands
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
```

## Queue / Scheduler
- Queue connection: `sync` by default.
- If using queues, set `QUEUE_CONNECTION` and start the worker:
  ```bash
  php artisan queue:work --tries=3
  ```
- For scheduling, add the cron entry:
  ```bash
  * * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
  ```

## Web Server
Reference configurations:
- Nginx: point root to `/public`
- Apache: use `.htaccess` in `public/`
- Ensure `mod_rewrite` is enabled for Apache.

## First Administrator
Use the application’s real mechanism (e.g., install wizard or admin creation route). After installation:
1. Log in with the initial admin account.
2. Change the default password if required by `force-password-change` rules.
3. Verify role assignment (`isAdmin`, `isSuperadmin`).

## Health Verification
Run:
```bash
php artisan about
php artisan route:list
php artisan test
```

## Import / Export Smoke Test
1. Download the sample XLSX from **Products > Sample**.
2. Verify headings match the canonical 12-column order.
3. Import the file.
4. Verify Bangla text is preserved.
5. Export all products and verify columns align with headings.

## Bangla Unicode Smoke Test
1. Create a product with Bangla name, position, user description, and remarks.
2. Save and reload.
3. Verify no `?` appears in any text field.
4. Download XLSX export and confirm Bangla is readable.
