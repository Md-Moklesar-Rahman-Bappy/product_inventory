# 🧿 Product Inventory Dashboard

A vibrant, responsive Laravel application for managing products with advanced CRUD operations, dashboard-level UI polish, and robust backend logic.

---

## 🚀 Features

- 🧩 Modular CRUD for Products, Brands, Categories, and Models
- 🔍 Search by Serial Number with pagination and highlight
- 🎨 Beautiful dashboard UI with gradient headers, badges, and icons
- 📦 Product creation with category, brand, model, serials, and remarks
- 🛡️ Form validation with feedback and empty state visuals
- 🧠 Blade components and DRY structure for maintainability

---

## 🛠️ Tech Stack

| Layer        | Tools & Frameworks               |
|-------------|----------------------------------|
| Backend      | Laravel 10+, Eloquent ORM        |
| Frontend     | Blade, Bootstrap 5, Font Awesome |
| UI/UX        | Custom CSS, gradient buttons     |
| Database     | MySQL / MariaDB                  |

---

## 📁 Folder Structure
├── app/ │   ├── Models/ │   ├── Http/Controllers/ │   └── Requests/ ├── resources/ │   ├── views/ │   │   ├── products/ │   │   ├── brands/ │   │   ├── categories/ │   │   └── models/ │   └── layouts/ ├── routes/ │   └── web.php


---

## ⚙️ Setup Instructions

1. **Clone the repo**
   ```bash
   git clone https://github.com/your-username/product-inventory-dashboard.git
   cd product-inventory-dashboard

   composer install
npm install && npm run dev

cp .env.example .env
php artisan key:generate

php artisan migrate
php artisan serve
---

🔍 Search Functionality
- Search by serial number from the product index page
- Pagination retains search query
- Matching serials are highlighted using <mark>
- Clean UI with instant feedback

📸 Screenshots
Add screenshots of your dashboard UI, product table, and create/edit forms here.

✨ UI/UX Highlights
- Gradient buttons with hover effects
- Font Awesome icons for actions
- Tooltips for clarity
- Empty states with illustrations and messages
- Consistent color palette across modules
- Responsive layout for desktop and mobile

🧠 Developer Notes
- Uses Laravel resourceful routing and route model binding
- Form requests handle validation cleanly
- Blade components for buttons, alerts, and form inputs
- Foreign key constraints enforced in migrations
- Modular design for scalability and maintainability

🙌 Credits
Crafted with ❤️ by Md Moklesar Rahman
Laravel architect & UI/UX designer
Focused on beauty, clarity, and backend precision.
📧 Email: md.moklasarrahmanbappy@gmail.co

📜 License
This project is open-source under the MIT Licens

🤝 Contributing
Pull requests are welcome! For major changes, please open an issue first to discuss what you’d like to change.

📬 Contact
For feedback, suggestions, or collaboration, feel free to reach out via email or GitHub.

