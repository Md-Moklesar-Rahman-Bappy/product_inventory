# 🏗️ Architecture Overview

This document describes the technical architecture of the **Product Inventory Dashboard**.  
It covers backend logic, frontend structure, database design, and deployment considerations.

---

## ⚙️ Backend (Laravel)
- **Framework**: Laravel 12 (PHP 8.2+)
- **ORM**: Eloquent ORM for database interactions
- **Routing**:
  - Resourceful routes for CRUD operations
  - Route model binding for cleaner controllers
- **Controllers**:
  - `ProductController`, `BrandController`, `CategoryController`, `ModelController`
- **Validation**:
  - Form Requests handle input validation
  - Custom error messages for user feedback
- **Security**:
  - CSRF protection enabled
  - Foreign key constraints enforced in migrations

---

## 🎨 Frontend (Blade + Bootstrap)
- **Templating**: Blade components for reusable UI
- **Styling**:
  - Bootstrap 5 grid system
  - Custom CSS for gradients, buttons, and badges
- **Icons**: Font Awesome for action buttons
- **UX Enhancements**:
  - Tooltips for clarity
  - Empty states with illustrations
  - Responsive layout for desktop and mobile

---

## 🗄️ Database Design
- **Tables**:
  - `products` → stores product details (serial, remarks, category_id, brand_id, model_id)
  - `categories` → product categories
  - `brands` → product brands
  - `models` → product models
- **Relationships**:
  - One-to-many: Category → Products
  - One-to-many: Brand → Products
  - One-to-many: Model → Products
- **Constraints**:
  - Foreign keys enforce relational integrity
  - Indexes on serial numbers for fast search

---

## 🔍 Search Functionality
- Search by serial number from product index
- Pagination retains search query
- Matching serials highlighted with `<mark>`
- Optimized queries for performance

---

## 🚀 Deployment
- **Environment Variables**:
  - Stored in `.env` file
  - Example: `DB_CONNECTION`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- **Server Requirements**:
  - PHP 8.2+
  - MySQL/MariaDB
  - Composer
- **Optional**:
  - Dockerfile for containerized deployment
  - CI/CD pipeline via GitHub Actions

---

## 📈 Scalability Notes
- Modular design for adding new modules (e.g., suppliers, stock levels)
- Blade components ensure DRY and maintainable UI
- Database indexing supports large product datasets