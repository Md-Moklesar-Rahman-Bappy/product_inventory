# Product Inventory / Equipment Inventory Management System

Version: 3.0.0
Release Date: 2026-10-28

## What This Package Contains

This archive (product_inventory/) contains a customer-installable runtime of the Equipment Inventory Management System.

It includes:
- Application source code (pp/, outes/, esources/)
- Database migrations and seeders (database/)
- Production-optimized Composer dependencies (endor/)
- Web entry point (public/)
- Browser-based installer (outes/install.php)
- Customer documentation (README.md, INSTALLATION.md, CHANGELOG.md, TROUBLESHOOTING.md)

It does NOT contain:
- Development-only dependencies (PHPUnit, Pest, etc.)
- Production secrets, .env, or database dumps
- Runtime logs, caches, or session files

## System Requirements

- PHP >= 8.2
- Required PHP extensions: mbstring, openssl, pdo, pdo_mysql, curl, json, ileinfo, gd, xml, zip, cmath, 	okenizer
- MySQL / MariaDB database
- Writable directories: storage/, ootstrap/cache
- Web server with document root pointing to public/

## Integrity Verification

Before extracting, verify the archive:

`ash
sha256sum -c SHA256SUMS.txt
`

Or on Windows (PowerShell):

`powershell
(Get-FileHash product_inventory.zip -Algorithm SHA256).Hash
`

Compare the result with the value in SHA256SUMS.txt.

## Quick Installation Overview

1. Extract product_inventory.zip
2. Place the product_inventory/ folder in your web server document root (e.g., htdocs/ for XAMPP, or /var/www/html/ for Nginx/Apache)
3. Create an empty MySQL/MariaDB database
4. Configure public/ as the document root
5. Ensure storage/ and ootstrap/cache/ are writable
6. Visit http://your-site/install/requirements in a browser
7. Follow the browser installer (database ? license activation ? first admin ? complete)

NOTE: This is NOT a "one-click" application. It requires PHP, a web server, PHP extensions, and a database to operate. The archive provides the runtime code and an installation assistant; it does not replace server setup.

## License Activation

The application uses a license server for activation. During installation, you will be asked for:
- License server URL (LICENSE_SERVER_URL)
- Product ID (LICENSE_PRODUCT_ID)
- License API key (LICENSE_API_KEY)
- Your license key

After installation, the license is cached securely in storage/app/license.json.

## Post-Install Security

- Change the initial super admin password regularly
- Keep .env out of public access
- Set APP_DEBUG=false in production
- Restrict access to /install routes after installation
- Do not share the LICENSE_API_KEY

## Support and Documentation

See INSTALLATION.md for platform-specific instructions (Windows XAMPP, Linux Apache/Nginx, cPanel/shared hosting).
See TROUBLESHOOTING.md for common errors (403, 404, 419, 500, blank page, database connection, Bangla display, position zero, import/export alignment).

## Upgrade Warning

Before upgrading, back up your database and the storage/app/license.json file. The charset migration (if applied) is not safely reversible without backups.
