# 📜 Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/).

---

## [Unreleased]
### Planned
- Inventory analytics dashboard
- Export products to CSV/Excel
- Role-based access control
- Supplier management module

---

## [v3-bugfix-security] - 2026-04-05
### Fixed
- Patched SQL injection vulnerability in product search
- Corrected pagination issue with filtered queries
- Fixed session handling bug causing unexpected logouts

### Security
- Added CodeQL scanning workflow for automated vulnerability detection
- Enabled Dependabot alerts for dependency updates
- Published initial [SECURITY.md](SECURITY.md) policy for responsible disclosure

### Changed
- Hardened validation rules for product creation forms
- Updated logging level defaults to `info` in production
- Improved error handling for failed database connections

---

## [1.0.0] - 2026-04-05
### Added
- Initial release of **Product Inventory Dashboard**
- CRUD operations for Products, Brands, Categories, and Models
- Search by Serial Number with pagination and highlight
- Dashboard UI with gradient headers, badges, and icons
- Product creation with category, brand, model, serials, and remarks
- Form validation with feedback and empty state visuals
- Blade components for buttons, alerts, and form inputs
- Responsive layout for desktop and mobile

### Changed
- Improved folder structure for maintainability
- Applied DRY principles with Blade components

### Fixed
- Validation errors now show inline feedback
- Pagination retains search queries correctly

---

## [0.1.0] - 2026-03-28
### Added
- Project scaffolding with Laravel 12.0+
- Basic CRUD for products
- Initial UI layout with Bootstrap 5