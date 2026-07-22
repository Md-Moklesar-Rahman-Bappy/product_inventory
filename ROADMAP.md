# Roadmap

This document outlines planned features and improvements for Product Inventory.

> **Note:** This roadmap is subject to change based on community feedback and priorities.

## Planned Features

### v1.1.0 — API & Authentication

| Feature | Status | Priority |
|---|---|---|
| REST API endpoints for all resources | Planned | High |
| Laravel Sanctum API authentication | Planned | High |
| API rate limiting and throttling | Planned | High |
| API documentation (OpenAPI/Swagger) | Planned | Medium |
| Two-factor authentication (2FA) | Planned | High |
| API token management for users | Planned | Medium |

### v1.2.0 — Media & Identification

| Feature | Status | Priority |
|---|---|---|
| Product image upload and gallery | Planned | High |
| Image resize and thumbnail generation | Planned | Medium |
| Barcode generation (Code 128, EAN-13) | Planned | High |
| QR code generation for products | Planned | High |
| Barcode/QR scanning for quick lookup | Planned | Medium |
| Print labels with barcode/QR | Planned | Low |

### v1.3.0 — Multi-Warehouse & Operations

| Feature | Status | Priority |
|---|---|---|
| Multi-warehouse support | Planned | High |
| Stock transfer between warehouses | Planned | High |
| Warehouse-level inventory counts | Planned | High |
| Bulk product operations (delete, update category) | Planned | High |
| Bulk import with preview and conflict resolution | Planned | Medium |
| Stock adjustment and audit log | Planned | Medium |

### v1.4.0 — Reporting & Analytics

| Feature | Status | Priority |
|---|---|---|
| Advanced reporting dashboard | Planned | High |
| Category-wise inventory report | Planned | Medium |
| Brand-wise inventory report | Planned | Medium |
| Maintenance history report | Planned | Medium |
| Warranty expiration forecast report | Planned | High |
| Export reports as PDF | Planned | Medium |
| Audit trail export (CSV/PDF) | Planned | Medium |
| Charts and visual analytics | Planned | Low |

### v1.5.0 — Frontend & Experience

| Feature | Status | Priority |
|---|---|---|
| Mobile-responsive Progressive Web App (PWA) | Planned | High |
| Dark mode toggle | Planned | Medium |
| Localization / multi-language support | Planned | Medium |
| Improved responsive tables on mobile | Planned | High |
| Keyboard shortcuts for common actions | Planned | Low |
| Real-time notifications (WebSocket) | Planned | Low |

### v2.0.0 — Infrastructure & Integrations

| Feature | Status | Priority |
|---|---|---|
| Docker & Docker Compose support | Planned | High |
| CI/CD pipeline (GitHub Actions) | Planned | Medium |
| Third-party API integrations (ERP, accounting) | Planned | Low |
| Webhook support for external system notifications | Planned | Low |
| Plugin/extension system | Planned | Low |
| Multi-tenancy support | Planned | Low |

## Under Consideration

These features have been proposed but are not yet scheduled:

- Product serialization and batch tracking
- Minimum stock level alerts with email notifications
- Purchase order management
- Supplier/vendor management
- Asset depreciation tracking
- Audit logging improvements with diff views
- Role permission customization (granular permissions beyond 3 tiers)
- LDAP/SSO authentication
- Product comparison view
- Export maintenance reports with cost tracking
- Integration with popular barcode scanners
- Mobile app (React Native or Flutter)
- GraphQL API support
- Elasticsearch integration for advanced search

## Completed

_This section will be populated as features are released._

## Contributing to the Roadmap

Have an idea? Open a [Feature Request](https://github.com/your-username/product_inventory/issues) issue with the **feature-request** label. Describe:

1. The problem your feature would solve
2. Your proposed solution
3. How you envision it working
4. Whether you'd be willing to contribute to its development

## Versioning

This project follows [Semantic Versioning](https://semver.org/):

- **Major** (X.0.0): Breaking changes or significant new features
- **Minor** (0.X.0): New features, backwards compatible
- **Patch** (0.0.X): Bug fixes, backwards compatible
