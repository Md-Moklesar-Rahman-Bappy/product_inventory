# Product Inventory Dashboard

## Client Documentation

---

**Developer:** Md Moklesar Rahman  
**Portfolio:** https://md-moklesar-rahman-bappy.github.io/Md-Moklesar-Rahman/  
**Version:** 1.0.0  
**Date:** July 2026

---

## Table of Contents

1. Introduction
2. Features Overview
3. System Requirements
4. Installation Guide
5. Browser-Based Installer (Step-by-Step)
6. User Roles and Permissions
7. Dashboard Overview
8. Product Management
9. Category Management
10. Brand Management
11. Model Management
12. Maintenance Management
13. Warranty Management
14. User Management
15. Activity Logs
16. Application Settings
17. Profile Management
18. Search Functionality
19. License System
20. API Reference
21. Configuration Reference
22. Troubleshooting
23. Security Features
24. Performance Optimization
25. Backup and Recovery
26. FAQ
27. Changelog
28. Support and Credits

---

## 1. Introduction

Product Inventory Dashboard is a comprehensive, browser-based inventory management application built with Laravel 12 and Bootstrap 5. It provides businesses with a powerful yet intuitive interface to manage their products, categories, brands, models, maintenance schedules, and warranties.

The application features a fully guided web-based installer that requires no command-line knowledge. Simply upload the ZIP file, open your browser, and follow the step-by-step installation wizard.

### Key Highlights

- **Zero CLI Required:** Entire installation through a browser-based wizard
- **Role-Based Access Control:** Three-tier permission system (Super Admin, Admin, User)
- **Responsive Design:** Works on desktop, tablet, and mobile browsers
- **Audit Trail:** Complete activity logging for all user actions
- **License Protected:** Secure license validation system
- **Production Ready:** Configured for shared hosting, VPS, cPanel, Apache, Nginx

### Technology Stack

| Layer         | Technology                          |
|---------------|-------------------------------------|
| Backend       | Laravel 12.0, PHP 8.2+             |
| Database      | MySQL 8.0+ / MariaDB 10.3+        |
| Frontend      | Bootstrap 5.3.3, Font Awesome 6    |
| Templates     | Blade templating engine             |
| ORM           | Eloquent ORM                        |
| Session       | Database / File                     |
| Cache         | Database / File                     |
| License       | Remote validation with HMAC signing |

---

## 2. Features Overview

### Core Features

- **Product Management** — Full CRUD with serial number tracking, import/export, and image uploads
- **Category Management** — Organize products into categories with hierarchical ordering
- **Brand Management** — Track brands associated with products
- **Model Management** — Link asset models to brands and categories
- **Maintenance Scheduling** — Schedule and track product maintenance activities
- **Warranty Tracking** — Record and monitor product warranty periods

### Administrative Features

- **Dashboard** — Real-time statistics with product counts, recent activity, and charts
- **User Management** — Create, edit, disable, and delete user accounts with role assignment
- **Activity Logs** — Complete audit trail of all user actions with filtering
- **Application Settings** — Configure application name, logo, license, and operational preferences
- **Profile Management** — User profiles with custom avatars and password management

### Security Features

- **CSRF Protection** — All forms protected against cross-site request forgery
- **XSS Prevention** — Blade template engine auto-escapes output
- **SQL Injection Prevention** — Eloquent ORM parameterized queries
- **Session Security** — Encrypted sessions with configurable drivers
- **Password Hashing** — Bcrypt with configurable rounds (default: 12)
- **License Verification** — Periodic remote license validation
- **Force Password Change** — Admins can force users to change passwords

---

## 3. System Requirements

### Server Requirements

| Component        | Minimum Required                              |
|------------------|-----------------------------------------------|
| **PHP**          | 8.2 or higher                                 |
| **PHP Extensions** | PDO, PDO_MySQL, mbstring, openssl, tokenizer, xml, ctype, json, bcmath, fileinfo, gd |
| **MySQL**        | 8.0 or MariaDB 10.3+                         |
| **Web Server**   | Apache 2.4+ (mod_rewrite) or Nginx 1.18+     |
| **Disk Space**   | 50 MB minimum                                 |
| **RAM**          | 256 MB PHP memory limit (512 MB recommended)  |
| **SSL**          | Recommended for production                    |

### Hosting Compatibility

- **Shared Hosting:** cPanel, DirectAdmin, Plesk
- **VPS/Dedicated:** Ubuntu, Debian, CentOS, AlmaLinux
- **Cloud:** AWS, DigitalOcean, Linode, Vultr
- **Local Development:** XAMPP, WAMP, Laragon, Docker

### Browser Support

| Browser            | Supported |
|--------------------|-----------|
| Chrome 90+         | Yes       |
| Firefox 88+        | Yes       |
| Safari 14+         | Yes       |
| Edge 90+           | Yes       |
| Opera 76+          | Yes       |
| Mobile Chrome      | Yes       |
| Mobile Safari      | Yes       |

---

## 4. Installation Guide

### Quick Start (5 Minutes)

1. **Download** the `product_inventory.zip` file
2. **Upload** to your web server via FTP, cPanel File Manager, or SSH
3. **Extract** the ZIP file in your document root
4. **Open browser** and navigate to `https://yourdomain.com/install`
5. **Follow the wizard** — 5 simple steps to complete installation

### Detailed Upload Instructions

#### cPanel File Manager
1. Log in to cPanel
2. Open File Manager
3. Navigate to `public_html/` (or your desired subdirectory)
4. Click "Upload" and select the ZIP file
5. After upload, right-click the ZIP and select "Extract"

#### FTP Upload
1. Connect via FTP (FileZilla, WinSCP, etc.)
2. Navigate to your web root directory
3. Upload the ZIP file
4. Extract on the server or download, extract locally, and re-upload

#### SSH / Command Line
```bash
cd /var/www/html
unzip product_inventory.zip
chmod -R 775 storage/ bootstrap/cache/
chown -R www-data:www-data storage/ bootstrap/cache/
```

---

## 5. Browser-Based Installer (Step-by-Step)

The installer is a 5-step wizard accessible at `/install`. Each step validates before proceeding.

### Step 1: System Requirements Check

The installer automatically checks:
- PHP version (8.2+)
- Required PHP extensions
- Directory permissions
- Database connectivity prerequisites

All checks must pass (green checkmarks) before proceeding. If any check fails, contact your hosting provider.

### Step 2: Database Configuration

Enter your MySQL database credentials:

| Field     | Description                          | Default          |
|-----------|--------------------------------------|------------------|
| Host      | Database server address              | `127.0.0.1`      |
| Port      | Database server port                 | `3306`           |
| Database  | Database name (must exist)           | —                |
| Username  | MySQL username with DB privileges    | —                |
| Password  | MySQL user password                  | —                |

> **Important:** Create the database and user BEFORE running the installer. Most hosting panels provide a "MySQL Databases" section for this.

### Step 3: License Activation

Enter your license credentials:

| Field                | Description                              |
|----------------------|------------------------------------------|
| License Key          | Your unique license key (INV-YYYY-XXXX-XXXX-XXXX format) |
| License Server URL   | The URL of the license validation server |

The installer validates the key remotely and activates your license. A valid license is required for the application to function.

### Step 4: Create Super Admin Account

Create your administrator account:

| Field    | Validation Rules                        |
|----------|-----------------------------------------|
| Name     | Required, 2-255 characters              |
| Email    | Required, valid email, unique            |
| Mobile   | Optional, numeric                       |
| Password | Required, minimum 8 characters          |

This account is created with **Super Admin** privileges (full access). No default or hardcoded credentials exist.

### Step 5: Installation Complete

The installer:
1. Writes the `.env` configuration file
2. Generates the application encryption key
3. Runs all database migrations
4. Seeds default settings
5. Creates the storage symbolic link
6. Configures safe session/cache defaults

Click **"Go to Dashboard"** to access the login page.

---

## 6. User Roles and Permissions

The application implements a 3-tier Role-Based Access Control (RBAC) system.

### Role Hierarchy

| Role            | Permission Level | Description                                    |
|-----------------|------------------|------------------------------------------------|
| **Super Admin** | 0 (Highest)      | Full system access, manages all users and settings |
| **Admin**       | 1                | Manages products, categories, brands, models    |
| **User**        | 2 (Lowest)       | Read-only dashboard access                      |

### Permission Matrix

| Feature              | Super Admin | Admin | User |
|----------------------|:-----------:|:-----:|:----:|
| Dashboard View       | Yes         | Yes   | Yes  |
| Product CRUD         | Yes         | Yes   | No   |
| Category CRUD        | Yes         | Yes   | No   |
| Brand CRUD           | Yes         | Yes   | No   |
| Model CRUD           | Yes         | Yes   | No   |
| Maintenance CRUD     | Yes         | Yes   | No   |
| Warranty View        | Yes         | Yes   | No   |
| User Management      | Yes         | No    | No   |
| Activity Logs        | Yes         | No    | No   |
| Application Settings | Yes         | No    | No   |
| License Management   | Yes         | No    | No   |

### First Login Flow

1. Navigate to `https://yourdomain.com/login`
2. Enter the credentials created during installation
3. Access the dashboard
4. Configure application settings
5. Create additional user accounts as needed

---

## 7. Dashboard Overview

The dashboard provides a real-time overview of your inventory system.

### Dashboard Widgets

- **Total Products** — Count of all products in the system
- **Total Categories** — Number of active categories
- **Total Brands** — Number of registered brands
- **Recent Activity** — Latest user actions and system events
- **Quick Actions** — Shortcuts to common tasks

### Navigation

The sidebar provides access to all modules:
- Dashboard (home)
- Products
- Categories
- Brands
- Models
- Maintenance
- Warranty
- Users (Admin only)
- Activity Logs (Admin only)
- Settings (Admin only)

---

## 8. Product Management

### Product Fields

| Field         | Type         | Required | Description                           |
|---------------|--------------|----------|---------------------------------------|
| Name          | Text         | Yes      | Product name                          |
| Serial Number | Text         | Yes      | Unique serial number for identification |
| Category      | Relationship | Yes      | Product category                      |
| Brand         | Relationship | Yes      | Product brand                         |
| Model         | Relationship | No       | Asset model                           |
| Description   | Textarea     | No       | Detailed description                  |
| Remarks       | Text         | No       | Additional notes                      |
| Image         | File         | No       | Product photo (uploaded to storage)   |

### Product Operations

- **Create** — Add new products with all details
- **Read** — View product list with filtering and pagination
- **Update** — Edit existing product information
- **Delete** — Remove products (with confirmation)
- **Import** — Bulk import products via Excel/CSV
- **Export** — Export product data to Excel/CSV
- **Search** — Find products by serial number with highlighted results

### Serial Number Search

- Enter a serial number in the search bar
- Results are paginated and highlighted
- Search retains context across pages
- Clear search to return to full list

---

## 9. Category Management

### Category Fields

| Field       | Type    | Required | Description                    |
|-------------|---------|----------|--------------------------------|
| Name        | Text    | Yes      | Category name (unique)         |
| Description | Text    | No       | Category description           |
| Sort Order  | Integer | No       | Display ordering               |

### Operations

- **Create** — Add new product categories
- **Read** — View all categories with product counts
- **Update** — Edit category details
- **Delete** — Remove categories (products must be reassigned first)

---

## 10. Brand Management

### Brand Fields

| Field       | Type    | Required | Description                    |
|-------------|---------|----------|--------------------------------|
| Name        | Text    | Yes      | Brand name (unique)            |
| Description | Text    | No       | Brand description              |
| Logo        | File    | No       | Brand logo image               |

### Operations

- **Create** — Add new brands
- **Read** — View all brands with associated products
- **Update** — Edit brand information
- **Delete** — Remove brands

---

## 11. Model Management

### Model Fields

| Field       | Type         | Required | Description                    |
|-------------|--------------|----------|--------------------------------|
| Name        | Text         | Yes      | Model name                     |
| Brand       | Relationship | Yes      | Associated brand               |
| Category    | Relationship | No       | Associated category            |
| Description | Text         | No       | Model description              |

### Operations

- **Create** — Add new asset models
- **Read** — View models linked to brands
- **Update** — Edit model details
- **Delete** — Remove models

---

## 12. Maintenance Management

### Maintenance Fields

| Field        | Type         | Required | Description                        |
|--------------|--------------|----------|------------------------------------|
| Product      | Relationship | Yes      | Product under maintenance          |
| Type         | Text         | Yes      | Type of maintenance                |
| Description  | Textarea     | Yes      | Maintenance details                |
| Status       | Enum         | Yes      | Pending / In Progress / Completed  |
| Scheduled At | DateTime     | Yes      | Scheduled maintenance date         |
| Completed At | DateTime     | No       | Actual completion date             |

### Operations

- **Create** — Schedule new maintenance
- **Read** — View maintenance schedule with filters
- **Update** — Update maintenance status and details
- **Delete** — Remove maintenance records

---

## 13. Warranty Management

### Warranty Fields

| Field       | Type         | Required | Description                    |
|-------------|--------------|----------|--------------------------------|
| Product     | Relationship | Yes      | Product under warranty         |
| Start Date  | Date         | Yes      | Warranty start date            |
| End Date    | Date         | Yes      | Warranty expiration date       |
| Provider    | Text         | No       | Warranty provider name         |
| Notes       | Text         | No       | Additional warranty notes      |

### Operations

- **View** — See all warranties with status (Active / Expired)
- **Add** — Attach warranty information to products
- **Edit** — Update warranty details
- **Delete** — Remove warranty records

---

## 14. User Management (Super Admin Only)

### User Fields

| Field      | Type         | Required | Description                          |
|------------|--------------|----------|--------------------------------------|
| Name       | Text         | Yes      | User's full name                     |
| Email      | Email        | Yes      | Unique email address                 |
| Mobile     | Text         | No       | Phone number                         |
| Password   | Password     | Yes      | Minimum 8 characters                 |
| Role       | Enum         | Yes      | Super Admin / Admin / User           |
| Status     | Enum         | Yes      | Active / Inactive                    |

### Operations

- **Create** — Add new user accounts
- **Read** — View all users with role badges
- **Update** — Edit user details and roles
- **Delete** — Remove user accounts
- **Toggle Status** — Activate/deactivate users
- **Force Password Change** — Require password reset on next login

### User Creation Rules

- Only Super Admins can create new users
- Admins cannot create other Admins or Super Admins
- Users cannot change their own role
- Email must be unique across the system

---

## 15. Activity Logs (Super Admin Only)

The activity log provides a complete audit trail of all system actions.

### Logged Events

- User login/logout
- Product create/update/delete
- Category create/update/delete
- Brand create/update/delete
- Model create/update/delete
- Maintenance create/update/delete
- User create/update/delete
- Settings changes
- License activation/deactivation

### Log Entry Fields

| Field     | Description                               |
|-----------|-------------------------------------------|
| User      | User who performed the action             |
| Action    | Type of action (created, updated, deleted)|
| Subject   | Affected entity (Product, User, etc.)     |
| Details   | Before/after values for changes           |
| Timestamp | When the action occurred                  |
| IP Address| Client IP address                         |

### Filtering

- Filter by user
- Filter by action type
- Filter by date range
- Search within log entries

---

## 16. Application Settings (Super Admin Only)

### Configurable Settings

| Setting            | Description                              | Default           |
|--------------------|------------------------------------------|-------------------|
| Application Name   | Display name for the application         | Product Inventory |
| Application Logo   | Logo displayed in header/sidebar         | Default logo      |
| Application Footer | Footer text                              | Default footer    |
| License Status     | Current license activation status        | —                 |
| License Key        | Active license key                       | —                 |

### License Information

The Settings page displays:
- License key (masked)
- License status (Active / Inactive / Expired)
- Expiration date
- Server connection status

---

## 17. Profile Management

All users can manage their own profile.

### Profile Fields

| Field         | Type   | Required | Description                    |
|---------------|--------|----------|--------------------------------|
| Name          | Text   | Yes      | Display name                   |
| Email         | Email  | Yes      | Email address                  |
| Mobile        | Text   | No       | Phone number                   |
| Profile Image | File   | No       | Profile photo                  |

### Profile Operations

- **Update Profile** — Change name, email, mobile, and profile image
- **Change Password** — Update account password (requires current password)
- **View Profile** — See account details and role

### Default Profile Image

Users without a custom profile photo display the default image at `public/images/default-profile.png`.

---

## 18. Search Functionality

### Product Search

- Accessible from the Products page search bar
- Searches by serial number
- Results highlighted with `<mark>` tags
- Paginated results (retains search context)
- Clear button to reset search

### Activity Log Search

- Filter by user, action type, or date
- Full-text search within log entries

---

## 19. License System

### How It Works

1. **During Installation:** You enter a valid license key and the license server URL
2. **Validation:** The system sends a request to the license server to validate the key
3. **Local Cache:** Validated license info is cached locally in encrypted format
4. **Periodic Checks:** The system periodically re-validates with the server
5. **Tamper Protection:** License files include HMAC checksums to prevent tampering

### License States

| State     | Description                              |
|-----------|------------------------------------------|
| Active    | License is valid and application works  |
| Inactive  | License has not been activated           |
| Expired   | License has passed its expiration date   |
| Suspended | License has been suspended by admin      |
| Revoked   | License has been permanently revoked     |

### License Error Page

If the license becomes invalid, the application displays a license error page with:
- Explanation of the issue
- Instructions to resolve
- Contact information for support

### Offline Grace Period

The application includes an offline grace period (default: 7 days). If the license server is temporarily unreachable, the application continues to function for the grace period duration.

---

## 20. API Reference

### License API (Internal)

The application communicates with the license server via RESTful API endpoints.

#### License Activation
```
POST /api/license/activate
```

#### License Check
```
POST /api/license/check
```

#### Health Check
```
GET /api/license/health
```

All requests include the `X-API-Key` header for authentication.

---

## 21. Configuration Reference

### Environment Variables (.env)

#### Application Settings
| Variable         | Description                        | Default             |
|------------------|------------------------------------|---------------------|
| APP_NAME         | Application name                   | Product Inventory   |
| APP_ENV          | Environment (local/production)     | production          |
| APP_KEY          | Encryption key (auto-generated)    | —                   |
| APP_DEBUG        | Debug mode                         | false               |
| APP_URL          | Application URL                    | http://localhost    |

#### Database Settings
| Variable      | Description                    | Default              |
|---------------|--------------------------------|----------------------|
| DB_CONNECTION | Database driver                | mysql                |
| DB_HOST       | Database host                  | 127.0.0.1            |
| DB_PORT       | Database port                  | 3306                 |
| DB_DATABASE   | Database name                  | product_inventory    |
| DB_USERNAME   | Database username              | root                 |
| DB_PASSWORD   | Database password              | —                    |

#### Session and Cache
| Variable       | Description                    | Default   |
|----------------|--------------------------------|-----------|
| SESSION_DRIVER | Session storage driver         | database  |
| CACHE_STORE    | Cache storage driver           | database  |
| QUEUE_CONNECTION | Queue driver                 | database  |

#### License Settings
| Variable                  | Description                      | Default                                    |
|---------------------------|----------------------------------|--------------------------------------------|
| LICENSE_SERVER_URL        | License server API endpoint      | http://localhost/license-server/public      |
| LICENSE_PRODUCT_ID        | Product identifier               | inventory                                  |
| LICENSE_APP_VERSION       | Application version              | 1.0.0                                      |
| LICENSE_CHECK_INTERVAL_DAYS | Days between license checks    | 7                                          |
| LICENSE_OFFLINE_GRACE_DAYS  | Days of offline operation      | 7                                          |
| LICENSE_REQUEST_TIMEOUT   | API request timeout (seconds)    | 10                                         |
| LICENSE_API_KEY           | Shared API key with license server | —                                        |

---

## 22. Troubleshooting

### Common Issues and Solutions

#### "Whoops, Something Went Wrong"
- **Cause:** PHP version too low or missing extensions
- **Solution:** Ensure PHP 8.2+ with all required extensions enabled

#### "Database Connection Refused"
- **Cause:** Incorrect database credentials or server not running
- **Solution:** Verify DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD in .env

#### "Permission Denied" on storage/
- **Cause:** Insufficient file system permissions
- **Solution:** `chmod -R 775 storage/ bootstrap/cache/`

#### License Activation Failed
- **Cause:** Invalid license key or server unreachable
- **Solution:** Verify license key and server URL; check outbound HTTP access

#### Application Shows Old Content
- **Cause:** Cached configuration
- **Solution:** `php artisan config:clear && php artisan cache:clear`

#### Storage Symlink Error
- **Cause:** Symlink not created or not supported
- **Solution:** `php artisan storage:link` or create manually

#### Session Expired Immediately
- **Cause:** Session driver not configured
- **Solution:** Ensure SESSION_DRIVER is set to `database` or `file` in .env

#### "Method Not Allowed" Error
- **Cause:** Form submission to wrong URL
- **Solution:** Clear browser cache and reload the page

---

## 23. Security Features

### Built-in Security Measures

| Feature                    | Implementation                              |
|----------------------------|---------------------------------------------|
| CSRF Protection            | Laravel CSRF tokens on all forms             |
| XSS Prevention             | Blade auto-escaping of all output            |
| SQL Injection Prevention   | Eloquent ORM parameterized queries           |
| Password Hashing           | Bcrypt with 12 rounds                        |
| Session Encryption         | Encrypted session cookies                    |
| HTTPS Enforcement          | Configurable via APP_URL                     |
| Content Security Policy    | Configurable via middleware                   |
| Rate Limiting              | Configurable for login and API endpoints     |
| Input Validation           | Server-side validation on all forms          |
| File Upload Security       | MIME type validation, size limits            |

### Security Best Practices

1. Use HTTPS in production
2. Keep APP_DEBUG=false in production
3. Use strong, unique passwords
4. Regularly update dependencies
5. Monitor activity logs for suspicious behavior
6. Restrict file permissions on .env file
7. Regular database backups

---

## 24. Performance Optimization

### Recommendations

1. **Enable OPcache** — PHP OPcache significantly improves performance
2. **Use Queue Workers** — For background tasks (email, imports)
3. **Database Indexing** — All foreign keys are indexed in migrations
4. **Cache Configuration** — Use Redis for caching in high-traffic environments
5. **Asset CDN** — Bootstrap and Font Awesome loaded via CDN
6. **Compression** — Enable GZIP on your web server
7. **Image Optimization** — Compress uploaded images

### .htaccess Optimizations (Included)

- GZIP compression enabled
- Browser caching headers
- Security headers (X-Frame-Options, X-Content-Type-Options)

---

## 25. Backup and Recovery

### What to Back Up

1. **Database** — Full MySQL dump
2. **Files** — Entire application directory
3. **.env** — Environment configuration
4. **storage/** — User uploads and license cache

### Backup Commands

```bash
# Database backup
mysqldump -u username -p product_inventory > backup_$(date +%Y%m%d).sql

# Full backup
tar -czf backup_$(date +%Y%m%d).tar.gz /path/to/product_inventory/
```

### Recovery Steps

1. Restore database from SQL dump
2. Upload application files
3. Restore .env file
4. Run `php artisan config:clear && php artisan cache:clear`
5. Verify license status

---

## 26. Frequently Asked Questions

**Q: Do I need to know programming to install this?**  
A: No. The browser-based installer guides you through every step.

**Q: Can I install this on shared hosting?**  
A: Yes. It works on cPanel, DirectAdmin, Plesk, and most shared hosting environments.

**Q: What if my license expires?**  
A: The application will display a license error page. Contact your developer to renew.

**Q: Can I create additional admin accounts?**  
A: Yes. Super Admins can create Admin and User accounts through User Management.

**Q: Is there a way to import products in bulk?**  
A: Yes. The Products page includes an Import feature for Excel/CSV files.

**Q: Can I customize the application name and logo?**  
A: Yes. Go to Settings (Super Admin only) to change the application name and logo.

**Q: How do I change my password?**  
A: Go to your Profile page and click "Change Password."

**Q: Can I use this on multiple domains?**  
A: Your license is typically tied to a specific domain. Check your license terms.

---

## 27. Changelog

### Version 1.0.0 (July 2026)

#### Added
- Browser-based 5-step installer wizard
- Full product CRUD with serial number search
- Category, Brand, and Model management
- Maintenance scheduling system
- Warranty tracking
- 3-tier RBAC (Super Admin, Admin, User)
- User management with role assignment
- Activity logging and audit trail
- Application settings panel
- Profile management with avatar upload
- License activation and validation system
- Excel/CSV import and export for products
- Responsive Bootstrap 5 UI
- Default profile image system
- Force password change capability

#### Security
- CSRF protection on all forms
- XSS prevention via Blade escaping
- SQL injection prevention via Eloquent ORM
- Bcrypt password hashing (12 rounds)
- Encrypted sessions
- HMAC-signed license files

---

## 28. Support and Credits

### Developer

**Md Moklesar Rahman**  
Laravel Architect & Full-Stack Developer

- **Portfolio:** https://md-moklesar-rahman-bappy.github.io/Md-Moklesar-Rahman/
- **Email:** md.moklasarrahmanbappy@gmail.com

### Built With

- [Laravel 12](https://laravel.com/)
- [Bootstrap 5](https://getbootstrap.com/)
- [Font Awesome 6](https://fontawesome.com/)
- [MySQL 8.0](https://www.mysql.com/)
- [PHP 8.2](https://www.php.net/)

### License

This project is proprietary software. Licensed for use by the purchasing client only.

---

*Thank you for choosing Product Inventory Dashboard!*
