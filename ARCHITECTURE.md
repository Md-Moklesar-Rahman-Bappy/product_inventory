# Architecture

This document describes the system architecture, design patterns, and project structure of Product Inventory.

## Overview

Product Inventory follows the **MVC (Model-View-Controller)** architectural pattern provided by the Laravel 12 framework. It is a server-rendered Blade application with no frontend build pipeline — all CSS and JavaScript are served via CDN (Bootstrap 5.3.3, Font Awesome).

```
┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│              │     │              │     │              │
│    Browser   │────▶│  Laravel     │────▶│   MySQL      │
│   (Blade)    │◀────│  Router /    │◀────│   Database   │
│              │     │  Controller  │     │              │
└──────────────┘     └──────┬───────┘     └──────────────┘
                            │
                     ┌──────┴───────┐
                     │              │
                     │   License    │
                     │   Server     │
                     │  (External)  │
                     └──────────────┘
```

## Directory Structure

```
product_inventory/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── DeleteControllerCommand.php       # Artisan cleanup command
│   ├── Exports/
│   │   ├── AssetModelProductExport.php           # Model-wise Excel export
│   │   ├── BrandProductExport.php                # Brand-wise Excel export
│   │   ├── CategoryProductExport.php             # Category-wise Excel export
│   │   ├── ProductExport.php                     # All-products Excel export
│   │   └── Sheets/
│   │       └── ProductCategorySheet.php          # Category sheet for multi-sheet exports
│   ├── Helpers/
│   │   └── StringHelper.php                      # String utility functions
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ActivityLogController.php         # Audit trail viewer & logger
│   │   │   ├── AssetModelController.php          # Model CRUD + restore/force-delete
│   │   │   ├── AuthController.php                # Login, logout, profile
│   │   │   ├── BrandController.php               # Brand CRUD + restore/force-delete
│   │   │   ├── CategoryController.php            # Category CRUD + restore/force-delete
│   │   │   ├── Controller.php                    # Base controller
│   │   │   ├── DashboardController.php           # Dashboard with stats
│   │   │   ├── EmailVerificationController.php   # Email verification flow
│   │   │   ├── MaintenanceController.php         # Maintenance CRUD + force-delete
│   │   │   ├── ProductController.php             # Product CRUD + import/export
│   │   │   ├── UserController.php                # User CRUD + toggle/restore
│   │   │   └── WarrantyController.php            # Warranty overview
│   │   └── Middleware/
│   │       ├── AuthAdmin.php                     # Admin (utype=ADM) guard
│   │       ├── EnsureUserIsActive.php            # Active status enforcement
│   │       └── RoleMiddleware.php                # Role-based access (0/1/2)
│   ├── Imports/
│   │   └── ProductImport.php                     # Maatwebsite CSV import
│   ├── Models/
│   │   ├── ActivityLog.php                       # Audit trail model
│   │   ├── AssetModel.php                        # Product model/type
│   │   ├── Brand.php                             # Brand entity
│   │   ├── Category.php                          # Category entity
│   │   ├── Maintenance.php                       # Maintenance record
│   │   ├── Product.php                           # Core product entity
│   │   └── User.php                              # User with roles & verification
│   ├── Notifications/
│   │   └── SendCredentialsNotification.php       # Credential delivery email
│   ├── Providers/
│   │   └── AppServiceProvider.php                # Application service bindings
│   └── View/
│       └── Components/
│           ├── PaginationBlock.php                # Reusable pagination component
│           ├── ProductTable.php                   # Product table component
│           └── WarrantyCountdown.php              # Warranty countdown component
├── bootstrap/                                    # Application bootstrapping
├── config/                                       # Laravel configuration
├── database/
│   ├── migrations/                               # Database schema migrations
│   ├── factories/                                # Model factories for testing
│   └── seeders/                                  # Database seeders
├── docs/                                         # Additional documentation
├── public/                                       # Web root (index.php, assets)
├── resources/
│   ├── views/                                    # Blade templates
│   │   ├── layouts/                              # Master layout with sidebar
│   │   ├── auth/                                 # Login, register views
│   │   ├── dashboard.blade.php                   # Main dashboard
│   │   ├── products/                             # Product CRUD views
│   │   ├── categories/                           # Category CRUD views
│   │   ├── brands/                               # Brand CRUD views
│   │   ├── models/                               # Asset model CRUD views
│   │   ├── users/                                # User management views
│   │   ├── maintenance/                          # Maintenance views
│   │   ├── activity_logs/                        # Activity log views
│   │   └── installer/                            # 5-step installer views
│   └── lang/                                     # Language/translation files
├── routes/
│   ├── web.php                                   # All web routes (106 lines)
│   └── console.php                               # Console/Artisan routes
├── storage/
│   ├── app/                                      # File uploads (profile photos)
│   ├── framework/                                # Cache, sessions, views
│   └── logs/                                     # Application logs
└── tests/
    ├── Pest.php                                  # Pest configuration
    ├── TestCase.php                              # Base test case
    ├── Feature/                                  # Feature/integration tests
    └── Unit/                                     # Unit tests
```

## Middleware Stack

Requests pass through the following middleware pipeline:

```
Request
  │
  ├── EncryptCookies
  ├── AddQueuedCookiesToResponse
  ├── StartSession
  ├── ShareErrorsFromSession
  ├── VerifyCsrfToken
  ├── SubstituteBindings
  │
  ├── InstalledMiddleware          # Redirects to installer if not installed
  ├── VerifyLicenseMiddleware      # Validates license with remote server
  ├── EnsureUserIsActive           # Logs out deactivated users
  │
  └── Route-specific:
      ├── auth                     # Authentication required
      ├── RoleMiddleware            # Role-based access (accepts role IDs)
      └── AuthAdmin                # Admin type guard (utype=ADM)
```

### Middleware Details

| Middleware | Purpose | Applied To |
|---|---|---|
| `InstalledMiddleware` | Checks if installer has been completed; redirects to installer wizard if not | Global route group |
| `VerifyLicenseMiddleware` | Validates application license against remote server with offline grace period | Global route group |
| `EnsureUserIsActive` | Checks `status` field; logs out and redirects deactivated users | Authenticated routes |
| `RoleMiddleware` | Accepts comma-separated role IDs (e.g., `0,1`); aborts 403 if user's `permission` doesn't match | Route-level |
| `AuthAdmin` | Checks `utype === 'ADM'`; logs out and redirects non-admin users | Admin-only routes |

## Model Relationships

```
User (1) ──────────┐
                    │
ActivityLog (N) ───┘ belongsTo(User)

Product (N) ── belongsTo ──▶ Category (1)
Product (N) ── belongsTo ──▶ Brand (1)
Product (N) ── belongsTo ──▶ AssetModel (1)

Category (1) ── hasMany ──▶ Product (N)
Brand (1)     ── hasMany ──▶ Product (N)
AssetModel (1) ── hasMany ──▶ Product (N)

Maintenance (N) ── belongsTo ──▶ Product (1)
Maintenance (N) ── belongsTo ──▶ User (1)
```

### Key Model Features

| Model | Traits | Key Fields |
|---|---|---|
| `User` | `HasFactory`, `Notifiable`, `SoftDeletes` | name, email, password, permission (0/1/2), utype, status, profile_photo_path |
| `Product` | `HasFactory`, `SoftDeletes` | product_name, price, category_id, brand_id, model_id, serial_no, project_serial_no, warranty_start, warranty_end |
| `Category` | `HasFactory`, `SoftDeletes` | category_name, status |
| `Brand` | `HasFactory`, `SoftDeletes` | brand_name, status |
| `AssetModel` | `HasFactory`, `SoftDeletes` | model_name, status |
| `Maintenance` | `SoftDeletes` | product_id, description, performed_at, start_time, end_time, user_id |
| `ActivityLog` | — | user_id, action, model, model_id, description, ip_address, user_agent, role |

## Service Layer

### LicenseService

Handles communication with the external license server:

- Validates license key against `LICENSE_SERVER_URL`
- Sends product ID, version, and API key
- Handles HTTP timeouts gracefully
- Implements offline grace period via `LICENSE_OFFLINE_GRACE_DAYS`
- Caches last valid license state for offline fallback

### ActivityLogController (Static Logger)

The `ActivityLogController::logAction()` static method serves as a centralized audit logging service:

```php
ActivityLogController::logAction(
    'create',           // Action type
    'Product',          // Model name
    $product->id,       // Model ID
    'Description...'    // HTML description
);
```

Called from controllers on create, update, delete, restore, import, and credential-sending events.

## Database Schema Overview

```
users
├── id, name, email, password, mobile, designation
├── about, address, profile_photo_path
├── permission (0=Superadmin, 1=Admin, 2=User)
├── utype, initial_password, credentials_sent_at
├── status (active/deactive)
├── email_verified_at, remember_token
└── created_at, updated_at, deleted_at

products
├── id, product_name, price, serial_no, project_serial_no
├── position, user_description, remarks
├── category_id (FK), brand_id (FK), model_id (FK)
├── warranty_start, warranty_end
└── created_at, updated_at, deleted_at

categories
├── id, category_name, status
└── created_at, updated_at, deleted_at

brands
├── id, brand_name, status
└── created_at, updated_at, deleted_at

asset_models
├── id, model_name, status
└── created_at, updated_at, deleted_at

maintenances
├── id, product_id (FK), user_id (FK)
├── description, performed_at
├── start_time, end_time
└── created_at, updated_at, deleted_at

activity_logs
├── id, user_id, action, model, model_id
├── description, ip_address, user_agent, role
└── created_at
```

## Installer Flow

```
Step 1                Step 2              Step 3              Step 4              Step 5
REQUIREMENTS ──────▶ DATABASE ──────▶ LICENSE ──────▶ ADMIN ──────▶ COMPLETE
                                                                    
┌─────────────┐    ┌─────────────┐   ┌─────────────┐   ┌─────────────┐   ┌─────────────┐
│ Check PHP   │    │ DB Host     │   │ License Key │   │ Admin Name  │   │ Summary     │
│ Extensions  │    │ DB Name     │   │ Server URL  │   │ Admin Email │   │ Success!    │
│ Check       │    │ DB User     │   │ Product ID  │   │ Password    │   │ Login Link  │
│ Permissions │    │ DB Pass     │   │ Verify ────▶│   │ Create ────▶│   │             │
│             │    │ Test ──────▶│   │             │   │             │   │             │
└─────────────┘    └─────────────┘   └─────────────┘   └─────────────┘   └─────────────┘
```

## Request Lifecycle

1. **HTTP Request** arrives at `public/index.php`
2. **Bootstrap** — Application kernel loads configuration and service providers
3. **Middleware Pipeline** — Request passes through global and route middleware
4. **Router** — Matches URL to a route in `routes/web.php`
5. **Controller** — Invokes the appropriate controller method
6. **Model/Eloquent** — Interacts with the MySQL database
7. **View/Blade** — Renders the response HTML
8. **Response** — Returns the rendered HTML to the browser

## Frontend Architecture

- **No build step** — Bootstrap 5.3.3 and Font Awesome served via CDN
- **Blade templates** with component-based architecture
- **Dark sidebar navigation** layout shared across all authenticated pages
- **Session-based authentication** with CSRF protection
- **Server-side rendering** — all data rendered in Blade, minimal JavaScript

## File Upload Flow

```
User Uploads Photo
       │
       ▼
UserController::update()
       │
       ▼
$request->file('profile_photo')->store('profile-photos', 'public')
       │
       ▼
storage/app/public/profile-photos/{hash}.{ext}
       │
       ▼
php artisan storage:link → public/storage → storage/app/public
```
