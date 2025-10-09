MIT License

Copyright (c) 2025 Md Moklesar Rahman

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

🧭 docs/ Folder Structure
Create a folder named docs/ with the following structure:

docs/
├── ui-guidelines.md
├── architecture.md
├── changelog.md
└── screenshots/
├── dashboard.png
├── product-form.png
└── empty-state.png

# 🎨 UI Guidelines

This dashboard follows a vibrant, consistent design language focused on clarity, accessibility, and user delight.

---

## ✨ Design Principles

-   **Gradient buttons** with hover transitions for visual feedback
-   **Font Awesome icons** for intuitive actions and navigation
-   **Tooltips** for clarity and accessibility across all interactive elements
-   **Empty states** with illustrations and friendly messages to guide users
-   **Consistent spacing**, padding, and visual hierarchy for readability

---

## 📦 Reusable Components

| Component      | Purpose                                     |
| -------------- | ------------------------------------------- |
| `x-button`     | Gradient-styled button with icon support    |
| `x-alert`      | Feedback messages with contextual styling   |
| `x-form-group` | Input wrapper with label, icon, and errors  |
| `x-badge`      | Status indicators with color-coded feedback |
| `x-modal`      | Reusable modal with header and slots        |

---

## 📱 Responsiveness

-   Built with **Bootstrap 5** grid system
-   Mobile-first layout with collapsible sidebar
-   Tables collapse gracefully on smaller screens
-   Forms stack vertically for readability
-   Charts resize dynamically using Chart.js

---

## 🖼️ Screenshots

| View         | Preview                        |
| ------------ | ------------------------------ |
| Dashboard    | `screenshots/dashboard.png`    |
| Product Form | `screenshots/product-form.png` |
| Empty State  | `screenshots/empty-state.png`  |

---

## 🧠 UX Enhancements

-   **Animated cards** using Animate.css for joyful transitions
-   **Badges** with rounded-pill styling for entity counts
-   **Real-time feedback** using Toastr or Blade alerts
-   **Accessible color contrast** and semantic HTML

---

## 🧼 Best Practices

-   Use Blade components for all reusable UI
-   Avoid inline styles — use utility classes
-   Keep forms and tables keyboard-accessible
-   Use `aria-labels` and `role` attributes where needed

---

Crafted with ❤️ by Md Moklesar Rahman  
Inspired by joyful UI and ethical Laravel architecture
