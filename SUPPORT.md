# Getting Help

Welcome to Product Inventory support. This guide will help you find the assistance you need.

## Documentation

| Document | Description |
|---|---|
| [README.md](README.md) | Project overview, features, and quick start |
| [INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md) | Detailed step-by-step installation instructions |
| [ENVIRONMENT.md](ENVIRONMENT.md) | Complete `.env` variable reference |
| [ARCHITECTURE.md](ARCHITECTURE.md) | System architecture and design patterns |
| [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md) | Production deployment guide |
| [TESTING_GUIDE.md](TESTING_GUIDE.md) | Testing setup and examples |
| [CHANGELOG.md](CHANGELOG.md) | Release history and version notes |
| [ROADMAP.md](ROADMAP.md) | Upcoming features and plans |

## GitHub Issues

For bug reports and feature requests:

1. **Search existing issues** — Your question may already be answered
2. **Check the FAQ** — Common problems are listed below
3. **Open a new issue** — Use the appropriate template:
   - **Bug Report** — For reproducible errors or unexpected behavior
   - **Feature Request** — For suggesting new functionality
   - **Question** — For usage questions not covered in documentation

**When reporting a bug, include:**
- Laravel version (`php artisan --version`)
- PHP version (`php --version`)
- MySQL version
- Steps to reproduce
- Expected vs actual behavior
- Relevant logs from `storage/logs/laravel.log`

## Email Support

| Purpose | Address |
|---|---|
| **General Support** | support@product-inventory.dev |
| **Security Vulnerabilities** | security@product-inventory.dev |
| **Business Inquiries** | contact@product-inventory.dev |

Response time: Within 48 hours on business days.

## FAQ

### Installation

**Q: The installer shows "Requirements Not Met" — what do I do?**

A: Ensure all required PHP extensions are installed and enabled:

```
mbstring, openssl, pdo, pdo_mysql, curl, json, fileinfo, gd, xml, zip, bcmath, tokenizer
```

On XAMPP, edit `php.ini` and uncomment the extension lines. Restart Apache after changes.

**Q: I get a "Database Connection Refused" error during installation.**

A: Verify your `.env` database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_inventory
DB_USERNAME=root
DB_PASSWORD=
```

Ensure MySQL is running: `mysql -u root -p`

**Q: How do I reset the application?**

A: Drop and recreate the database, remove the `.env` file, and run the installer wizard again:

```bash
mysql -u root -e "DROP DATABASE product_inventory; CREATE DATABASE product_inventory;"
rm .env
php artisan key:generate
php artisan storage:link
# Then open the installer in your browser
```

**Q: The installer doesn't appear — I see a 404 or login page instead.**

A: The installer routes are only available when no admin user exists. If you've already completed installation, you cannot re-run the installer without resetting the database.

### Authentication

**Q: My account is deactivated. What should I do?**

A: Contact a Superadmin to reactivate your account via the User Management panel. Only Superadmins and Admins can toggle user status.

**Q: I didn't receive the verification email.**

A: Check your spam folder. Ensure your mail settings in `.env` are correct. For local development, you can use Mailtrap or configure `MAIL_MAILER=log` to see emails in `storage/logs/laravel.log`.

**Q: How do I change my password?**

A: Navigate to your profile page from the sidebar. You can update your password and profile photo there.

### Products

**Q: How do I import products from Excel?**

A: Go to Products → Import. Download the sample CSV file first to see the required format. Upload your CSV, and the system will validate and import entries. Skipped rows can be exported and reviewed.

**Q: What does "Urgency Level" mean in the warranty overview?**

A: Urgency is calculated based on days remaining until warranty expiration:
- **Level 0 (Expired):** Warranty has ended
- **Level 1 (Critical):** Expires within 7 days
- **Level 2 (Warning):** Expires within 30 days
- **Level 3 (Good):** More than 30 days remaining
- **Level 4 (Unknown):** No warranty date set

**Q: Can I recover deleted products?**

A: Yes. Products use soft deletes. Contact an admin to restore soft-deleted products, or use the restore route on the product page. Force-delete permanently removes the record.

### Deployment

**Q: How do I deploy to production?**

A: See [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md) for comprehensive instructions covering:
- Server requirements (Ubuntu/Nginx/Apache)
- Environment configuration
- Optimization commands
- Queue worker setup
- SSL configuration

**Q: How do I set up the cron job?**

A: Add this to your server's crontab:

```bash
* * * * * cd /path/to/product_inventory && php artisan schedule:run >> /dev/null 2>&1
```

### License

**Q: What happens if the license server is unreachable?**

A: The system has an offline grace period controlled by `LICENSE_OFFLINE_GRACE_DAYS`. During this period, the application continues to function normally. After the grace period expires, the application will require re-verification.

**Q: Where do I get a license key?**

A: License keys are provided through the license dashboard server configured in your `LICENSE_SERVER_URL` environment variable.

## Community

If you have questions or want to discuss the project:

1. Check the [GitHub Discussions](https://github.com/your-username/product_inventory/discussions) page
2. Review existing issues and documentation
3. Open a new issue with the **Question** template

## Contributing

Want to contribute? See [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.
