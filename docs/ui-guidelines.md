# 🎨 UI Guidelines

This dashboard follows a vibrant, consistent design language focused on clarity, responsiveness, and user delight.

---

## 🧭 Design Principles
- Gradient buttons with smooth hover effects
- Font Awesome icons for intuitive actions
- Tooltips for clarity and accessibility
- Empty states with illustrations and friendly messages
- Consistent spacing, padding, and visual hierarchy
- Color palette aligned across modules for brand consistency

---

## 📦 Components
- **`x-button`** → Reusable button with gradient styling
- **`x-alert`** → Feedback messages with icons and contextual colors
- **`x-form-group`** → Input wrapper with label, validation, and error feedback
- **`x-card`** → Dashboard cards with headers, badges, and icons
- **`x-table`** → Responsive product tables with pagination and search highlights

---

## 📱 Responsiveness
- Mobile-first layout using Bootstrap grid system
- Tables collapse gracefully on smaller screens
- Forms stack vertically for readability
- Navigation adapts to mobile with collapsible menus
- Dashboard widgets resize dynamically for different viewports

---

## 📸 Screenshots
Screenshots are stored in `docs/screenshots/`:

- `dashboard.png` → Main dashboard view with product stats
- `activity-log.png` → Full application log
- `products.png` → Products Page
- `maintenance.png` → Product Maintenance
- `product-warranty.png` → Product Warranty
- `user-management.png` → User Management Section
- `application-settings.png` → Application Setting

Add more screenshots here as features evolve.

---

## 🧠 Developer Notes
- Blade components enforce DRY structure
- Consistent use of Bootstrap 5 utilities for spacing and alignment
- Icons standardized with Font Awesome
- Forms validated with Laravel Form Requests
- UI tested across desktop and mobile breakpoints