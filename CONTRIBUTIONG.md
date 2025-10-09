# 🤝 Contributing Guide

Thank you for considering contributing to the **DLRS Inventory System** — a Laravel-based equipment management platform built for clarity, maintainability, and joyful user experience.

We welcome thoughtful contributions that improve functionality, accessibility, performance, or documentation. Whether you're fixing a bug, adding a feature, or refining UI/UX, your input matters!

---

## 🧩 How to Contribute

### 🐛 Report Bugs

-   Use the [Issues](https://github.com/Md-Moklesar-Rahman-Bappy/product_inventory/issues) tab to report bugs.
-   Include steps to reproduce, expected behavior, and screenshots if possible.
-   Label your issue with `bug`.

### 💡 Request Features

-   Suggest enhancements via Issues with a clear use case.
-   Label your request as `enhancement` or `feature`.
-   Describe how the feature improves usability or maintainability.

### 🛠 Submit Improvements

1. **Fork the repository**

2. **Create a new branch**

    ```bash
    git checkout -b feature/my-feature

    ```

3. Make your changes
    - Use clear, modular commits
    - Follow Laravel conventions and naming standards
4. Run tests and lint checks
5. Push your branch
   bash
   git push origin feature/my-feature

6. Open a Pull Request with a descriptive title and summary
    - Use a descriptive title
    - Summarize what you changed and why

🧪 Testing
We use Laravel’s built-in testing framework. Before submitting a PR, run:

php artisan test
bash
php artisan test

To run specific tests
bash
php artisan test --filter=TestClassName

✅ Please ensure all tests pass
🧪 Write new tests for any added functionalit

🧼 Code Style & Standards

-   Follow PSR-12 coding standards
-   Use Blade components for reusable UI
-   Avoid inline styles — use Tailwind or Bootstrap classes
-   Use Eloquent relationships and resource controllers
-   Name routes, models, and migrations clearly and consistently
-   Keep controllers lean — use services or traits for logic

📦 Dependencies

-   Use Composer for PHP packages:
    bash
    composer install
-   Use npm for frontend assets:
    bash
    npm install && npm run dev

📄 Licensing & Ethic
This project is licensed under GPL-3.0. All contributions must comply with open-source ethics:

-   Attribute third-party assets
-   Avoid proprietary or unlicensed code
-   Respect user privacy and transparency
-   Ensure accessibility and maintainability

🙌 Community Value
We value:

-   Clear communication
-   Respectful collaboration
-   Accessibility-first design
-   Ethical, open-source stewardship
-   Maintainable and joyful code

Happy coding! 🎉
— Md Moklesar Rahman & the DLRS Inventory Team

---

Let me know if you’d like me to generate:

-   `CODE_OF_CONDUCT.md` for community standards
-   `CHANGELOG.md` to track version history
-   GitHub Actions for automated testing and linting

This guide sets the tone for a transparent, collaborative, and joyful Laravel project. Let’s make it shine!
