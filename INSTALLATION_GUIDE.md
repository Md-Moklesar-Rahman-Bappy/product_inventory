# Installation Guide

This guide provides detailed step-by-step instructions for installing Product Inventory.

## Table of Contents

- [Server Requirements](#server-requirements)
- [Local Development Setup](#local-development-setup)
- [Installation via Browser Wizard](#installation-via-browser-wizard)
- [Manual CLI Installation](#manual-cli-installation)
- [XAMPP / WAMP Notes](#xampp--wamp-notes)
- [Post-Installation](#post-installation)

## Server Requirements

| Requirement | Minimum | Recommended |
|---|---|---|
| **PHP** | 8.2.0 | 8.2.12+ |
| **MySQL** | 5.7 | 8.0+ |
| **Composer** | 2.0 | Latest |
| **Web Server** | Apache 2.4 / Nginx 1.18 | Latest |
| **BCrypt Rounds** | 4 | 12 (production) |

### Required PHP Extensions

Ensure the following extensions are enabled in your `php.ini`:

| Extension | Purpose |
|---|---|
| `mbstring` | Multibyte string handling |
| `openssl` | Encryption and SSL |
| `pdo` | PHP Data Objects abstraction |
| `pdo_mysql` | MySQL database driver |
| `curl` | HTTP requests (license verification) |
| `json` | JSON encoding/decoding |
| `fileinfo` | File type detection |
| `gd` | Image processing (profile photos) |
| `xml` | XML parsing (Excel import/export) |
| `zip` | ZIP archive handling |
| `bcmath` | Arbitrary precision mathematics |
| `tokenizer` | PHP token parsing |

Verify enabled extensions:

```bash
php -m
```

Or check `phpinfo()` in a web-accessible file.

## Local Development Setup

### Step 1: Clone the Repository

```bash
git clone https://github.com/your-username/product_inventory.git
cd product_inventory
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

This installs all dependencies from `composer.json` including:
- `laravel/framework` ^12.0
- `maatwebsite/excel` ^3.1
- `spatie/laravel-activitylog` ^4.10
- `pestphp/pest` ^3.8 (dev)

### Step 3: Copy Environment File

```bash
cp .env.example .env
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

This generates a 32-character random key and writes it to `APP_KEY` in `.env`.

### Step 5: Configure Environment Variables

Edit `.env` with your database credentials:

```env
APP_NAME="Product Inventory"
APP_ENV=local
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_URL=http://localhost:8000
APP_TIMEZONE=Asia/Dhaka

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_inventory
DB_USERNAME=root
DB_PASSWORD=

LICENSE_SERVER_URL=https://your-license-server.com
LICENSE_PRODUCT_ID=your-product-id
LICENSE_APP_VERSION=1.0.0
LICENSE_CHECK_INTERVAL_DAYS=7
LICENSE_OFFLINE_GRACE_DAYS=14
LICENSE_REQUEST_TIMEOUT=10
LICENSE_API_KEY=your-api-key
```

### Step 6: Create the Database

```bash
mysql -u root -e "CREATE DATABASE product_inventory"
```

Or via phpMyAdmin:
1. Open phpMyAdmin
2. Click "New" in the sidebar
3. Enter `product_inventory` as the database name
4. Click "Create"

### Step 7: Create Storage Link

```bash
php artisan storage:link
```

This creates a symlink from `public/storage` to `storage/app/public` for serving uploaded files (profile photos).

### Step 8: Start the Development Server

```bash
php artisan serve
```

The application is now available at `http://localhost:8000`.

## Installation via Browser Wizard

After starting the server, open `http://localhost:8000` in your browser. The installer wizard will launch automatically if no admin user exists.

### Step 1: Requirements Check

The installer verifies:
- All required PHP extensions are loaded
- The `storage/` directory is writable
- The `bootstrap/cache/` directory is writable
- PHP version meets the minimum requirement

If any check fails, the installer displays which requirements are missing. Fix the issues and click **Re-check**.

### Step 2: Database Configuration

Enter your database connection details:

| Field | Description | Example |
|---|---|---|
| **Database Host** | MySQL server address | `127.0.0.1` |
| **Database Port** | MySQL port | `3306` |
| **Database Name** | Name of the database | `product_inventory` |
| **Database Username** | MySQL username | `root` |
| **Database Password** | MySQL password | *(leave empty for XAMPP default)* |

Click **Test Connection** to verify. On success, the installer will:
1. Write database credentials to `.env`
2. Run all database migrations
3. Seed initial data if applicable

### Step 3: License Verification

Enter your license credentials:

| Field | Description |
|---|---|
| **License Server URL** | URL of the license dashboard server |
| **Product ID** | Your product identifier |
| **API Key** | Authentication key for the license server |

The installer contacts the license server to validate your key. On success, these values are written to `.env`.

### Step 4: Admin Account Creation

Create the initial Superadmin account:

| Field | Requirements |
|---|---|
| **Name** | Full name of the administrator |
| **Email** | Valid email address (used for login) |
| **Password** | Minimum 8 characters |

This account has **Superadmin** role (permission level `0`) with full access to all features including user management and settings.

### Step 5: Installation Complete

The installer confirms successful setup and displays:
- Installation summary
- Link to the login page
- Reminder to verify email if email verification is enabled

After completion, the installer routes are disabled. The `InstalledMiddleware` prevents re-running the wizard.

## Manual CLI Installation

If you prefer to install via the command line without the browser wizard:

```bash
# 1. Complete steps 1-6 from Local Development Setup above

# 2. Run migrations
php artisan migrate

# 3. Create the admin user via Tinker
php artisan tinker
```

```php
// In Tinker:
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('your-password'),
    'permission' => 0,
    'utype' => 'ADM',
    'status' => 'active',
    'email_verified_at' => now(),
]);
exit;
```

```bash
# 4. Mark the application as installed
php artisan tinker
```

```php
// In Tinker, create an installer completion record or set the appropriate config:
// The exact method depends on how InstalledMiddleware checks installation status.
// Typically this is a settings table entry or a file-based flag.
App\Models\Setting::create([
    'key' => 'installed',
    'value' => '1',
]);
exit;
```

```bash
# 5. Verify installation
php artisan route:list
```

## XAMPP / WAMP Notes

### XAMPP (Windows)

1. **PHP Extensions**: Edit `C:\xampp\php\php.ini`
   - Uncomment extension lines by removing the leading `;`:
     ```ini
     extension=curl
     extension=gd
     extension=mbstring
     extension=mysqli
     extension=pdo_mysql
     extension=xml
     extension=zip
     extension=bcmath
     ```

2. **Restart Apache** after changes: XAMPP Control Panel → Stop → Start Apache

3. **MySQL**: Default credentials are `root` with no password

4. **File Permissions**: On Windows, permissions are typically not an issue. If遇到 problems, ensure the `storage/` and `bootstrap/cache/` directories are writable by the Apache user.

5. **Composer**: If not installed globally, use the XAMPP Composer installer or download `composer.phar` and run `php composer.phar install`

### WAMP (Windows)

1. **PHP Extensions**: Edit `C:\wamp\bin\php\phpX.X.X\php.ini`
   - Same extensions as XAMPP above

2. **MySQL**: Default credentials are `root` with no password

3. **Restart All Services** after making changes

4. **Virtual Host** (optional): Configure a virtual host for a custom domain:
   ```apache
   <VirtualHost *:80>
       DocumentRoot "D:/path/to/product_inventory/public"
       ServerName product-inventory.test
   </VirtualHost>
   ```

### Common Windows Issues

| Issue | Solution |
|---|---|
| `php` not recognized | Add PHP directory to system PATH |
| `composer` not recognized | Install globally or use `php composer.phar` |
| Permission denied on storage | Run terminal as Administrator |
| Port 80 already in use | Change Apache port in `httpd.conf` or stop conflicting services |
| MySQL connection refused | Ensure MySQL service is running in XAMPP/WAMP control panel |

## Post-Installation

### Verify Installation

```bash
# Check routes are registered
php artisan route:list

# Verify database tables
php artisan migrate:status

# Check application status
php artisan about
```

### Initial Login

1. Navigate to `http://localhost:8000/login`
2. Enter the admin email and password created during installation
3. If email verification is required, verify via the link sent to your email
4. You'll be redirected to the **Dashboard**

### Recommended Next Steps

1. **Configure Mail** — Set up SMTP for email verification and credential sending
2. **Create Test Users** — Add users with different roles to test access levels
3. **Import Products** — Use the CSV import feature to bulk-add inventory
4. **Set Up Categories** — Create categories and brands before adding products
5. **Review Activity Logs** — Monitor the audit trail from the dashboard
6. **Set Up Backups** — Configure regular MySQL backups

### Troubleshooting

| Problem | Solution |
|---|---|
| Blank page after install | Run `php artisan config:clear && php artisan cache:clear` |
| 403 Forbidden | Check `storage/` and `bootstrap/cache/` permissions |
| Installer still showing | Ensure the admin user was created and the installed flag is set |
| Import fails | Check `upload_max_filesize` and `post_max_size` in `php.ini` |
| License error | Verify `LICENSE_SERVER_URL` and `LICENSE_API_KEY` in `.env` |
| Profile photo not showing | Run `php artisan storage:link` |
