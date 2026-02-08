🧿 Product Inventory Dashboar

A vibrant, responsive Laravel application for managing products with modular CRUD, polished dashboard UI, and robust backend logic. Built for clarity, scalability, and joy.

🚀 Features

-   🧩 Modular CRUD for Products, Brands, Categories, and Models
-   🔍 Smart Search by Serial Number with pagination and highlight
-   🎨 Beautiful Dashboard UI with gradient headers, badges, and icons
-   📦 Product Creation with category, brand, model, serials, and remarks
-   🛡️ Form Validation with feedback and empty state illustrations
-   🧠 Blade Components for DRY, maintainable structur

🛠️ Tech Stack
|Layer |Tools & Frameworks |
|Backend |Laravel 10+, Eloquent ORM |
|Frontend |Blade, Bootstrap 5, Font Awesome|
|UI/UX |Custom CSS, gradient buttons |
|Database |MySQL / MariaDB |

📁 Folder Structure
├── app/
│ ├── Models/
│ ├── Http/Controllers/
│ └── Requests/
├── resources/
│ ├── views/
│ │ ├── products/
│ │ ├── brands/
│ │ ├── categories/
│ │ └── models/
│ └── layouts/
├── routes/
│ └── web.php

⚙️ Setup Instructions

-   Clone the repository
    git clone https://github.com/your-username/product-inventory-dashboard.git
    cd product-inventory-dashboard
    - Install dependencies
    composer install
    npm install && npm run dev
-   Configure environment
    cp .env.example .env
    php artisan key:generate
-   Run migrations and start server
    php artisan migrate
    php artisan serve

🔍 Search Functionality

-   Search by serial number from the product index page
-   Pagination retains search query
-   Matching serials are highlighted using <mark>
-   Clean UI with instant feedback and graceful empty states

📸 Screenshots
Add screenshots of your dashboard UI, product table, and create/edit forms here to showcase the visual polish.

✨ UI/UX Highlights

-   Gradient buttons with hover effects
-   Font Awesome icons for actions
-   Tooltips for clarity and accessibility
-   Empty states with illustrations and friendly messages
-   Consistent color palette across modules
-   Responsive layout for desktop and mobile

🧠 Developer Notes

-   Laravel resourceful routing and route model binding
-   Form requests for clean validation logic
-   Blade components for buttons, alerts, and form inputs
-   Foreign key constraints enforced in migrations
-   Modular design for scalability and maintainability

🙌 Credits
Crafted with ❤️ by Md Moklesar Rahman
Laravel architect & UI/UX designer
Focused on beauty, clarity, and backend precision.
📧 Email: md.moklasarrahmanbappy@gmail.com

📜 License
This project is open-source under the MIT License.

🤝 Contributing
Pull requests are welcome! For major changes, please open an issue first to discuss what you’d like to improve.

📬 Contact
For feedback, suggestions, or collaboration, feel free to reach out via GitHub or email.
