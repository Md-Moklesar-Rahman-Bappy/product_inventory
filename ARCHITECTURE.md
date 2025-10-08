# 🏗️ Project Architecture

This Laravel dashboard is built with a modular, scalable architecture that balances backend robustness with frontend beauty.

---

## 📦 Modules

Each entity (Product, Brand, Category, Model) follows a consistent CRUD structure:

- **Model**: Eloquent ORM with relationships
- **Controller**: Resourceful methods (`index`, `create`, `store`, `edit`, `update`, `destroy`)
- **Request**: Form validation logic
- **Views**: Blade templates for each action

---

## 🔄 Routing

- Resourceful routes defined in `web.php`
- Route model binding for cleaner controllers
- Named routes used in views for clarity

```php
Route::resource('products', ProductController::class);

🧠 Blade Components
Reusable UI elements for consistency and DRY code:
- x-button
- x-alert
- x-form-group
- x-empty-state

🛡️ Validation
- Form requests handle validation logic
- Errors displayed inline with feedback icons
- Smart defaults for optional field

🔍 Search & Pagination
- Search by serial number using query parameters
- Pagination retains search input
- Highlighted results using <mark>

🧱 Database Design
- Foreign key relationships between products, brands, categories, and models
- Migration files include constraints and indexing
- Seeders available for sample data (optional)

🎨 UI/UX Strategy
- Gradient buttons and icons for visual hierarchy
- Tooltips for clarity
- Empty states with illustrations
- Responsive layout using Bootstrap grid


---

### 📅 `docs/changelog.md`

```markdown
# 📅 Changelog

All notable changes to this project will be documented here.

---

## [v1.0.0] - 2025-08-11

### Added
- CRUD for Products, Brands, Categories, Models
- Serial number search with pagination
- Blade components for buttons, alerts, forms
- Gradient buttons and Font Awesome icons
- Empty state visuals and tooltips
- Form validation with feedback

### Improved
- Consistent UI across all modules
- DRY structure with reusable components
- Responsive layout for mobile and desktop

### Fixed
- Foreign key migration errors
- Naming collisions in models and tables













