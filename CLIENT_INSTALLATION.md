# Product Inventory Dashboard - Client Installation Guide

**Version:** 1.0.0  
**Developer:** Md Moklesar Rahman  
**Portfolio:** https://md-moklesar-rahman-bappy.github.io/Md-Moklesar-Rahman/

---

## Overview

Product Inventory Dashboard is a browser-based inventory management system. Installation is fully guided through a web wizard — **no coding or technical expertise required**. Simply upload the ZIP file, open your browser, and follow the step-by-step installer.

---

## System Requirements

| Component        | Minimum Required           |
|------------------|----------------------------|
| **PHP**          | 8.2 or higher              |
| **Extensions**   | PDO, PDO_MySQL, mbstring, openssl, tokenizer, xml, ctype, json, bcmath, fileinfo, gd |
| **MySQL**        | 8.0 or MariaDB 10.3+       |
| **Web Server**   | Apache (mod_rewrite) or Nginx |
| **Disk Space**   | 50 MB minimum              |
| **Memory**       | 256 MB PHP memory limit    |

---

## Installation Steps

### Step 1: Upload Files

1. Download the `product_inventory.zip` file.
2. Upload the ZIP to your web server's document root:
   - **cPanel:** Upload to `public_html/` or a subdirectory like `public_html/inventory/`
   - **VPS (Apache):** Upload to `/var/www/html/` or your configured `DocumentRoot`
   - **VPS (Nginx):** Upload to your configured root directory
   - **XAMPP:** Upload to `C:\xampp\htdocs\inventory\`
3. **Extract the ZIP file** using your hosting file manager or SSH:
   ```bash
   unzip product_inventory.zip
   ```

### Step 2: Set Permissions (if needed)

On Linux/VPS servers, ensure the `storage` and `bootstrap/cache` directories are writable:

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chown -R www-data:www-data storage/ bootstrap/cache/
```

> **cPanel users:** If you get permission errors, set permissions to `775` or `777` via the File Manager.

### Step 3: Open the Installer

Open your web browser and navigate to:

```
https://yourdomain.com/install
```

If the application is in a subdirectory:

```
https://yourdomain.com/inventory/install
```

### Step 4: Follow the 5-Step Wizard

#### Step 1 — System Requirements
The installer checks that your server meets all requirements. If anything shows as "Failed," contact your hosting provider to enable the missing PHP extension or setting.

#### Step 2 — Database Connection
Enter your MySQL database credentials:

| Field        | What to Enter                                    |
|--------------|--------------------------------------------------|
| Host         | Usually `127.0.0.1` or `localhost`               |
| Port         | Usually `3306`                                   |
| Database     | The database name you created                     |
| Username     | Your MySQL username                               |
| Password     | Your MySQL password                               |

> **Tip:** Create the database first via cPanel > MySQL Databases or phpMyAdmin before running the installer.

#### Step 3 — License Activation
Enter your **License Key** (provided with your purchase):

- The key format is: `INV-YYYY-XXXX-XXXX-XXXX`
- Enter the **License Server URL** (provided by your developer)
- The installer will validate the key and activate your license

#### Step 4 — Create Admin Account
Enter your Super Admin credentials:

| Field    | What to Enter                              |
|----------|---------------------------------------------|
| Name     | Your full name                              |
| Email    | Your email address                          |
| Mobile   | Your mobile number (optional)               |
| Password | A strong password (8+ characters)           |

> **Important:** These credentials are created by you during installation. There are NO default or hardcoded accounts.

#### Step 5 — Installation Complete
The installer will:
- Write your `.env` configuration
- Run all database migrations
- Create storage symlinks
- Display a success message

Click **"Go to Dashboard"** to log in.

### Step 5: Log In

1. Navigate to `https://yourdomain.com/login`
2. Enter the admin credentials you created in Step 4
3. You'll be directed to the Dashboard

---

## First-Time Setup Recommendations

1. **Review Settings** — Go to Settings to configure your application name, logo, and preferences.
2. **Create User Roles** — Add Admin and User accounts for your team via User Management.
3. **Start Adding Inventory** — Create Categories, Brands, and Models before adding Products.
4. **Configure License** — Ensure the license is active (check Settings for license status).

---

## Role-Based Access Control

| Role            | Permission Level | Capabilities                                    |
|-----------------|------------------|------------------------------------------------|
| **Super Admin** | Full access      | Manage all users, settings, products, categories, brands, models, maintenance, warranty |
| **Admin**       | Standard access  | Manage categories, brands, products, models     |
| **User**        | Read-only        | View dashboard only                             |

---

## Default Profile Image

A default profile image is included at `public/images/default-profile.png`. Users without a custom profile photo will display this image.

---

## License Information

Your license key is validated against a remote license server. The license must remain active for the application to function.

- **Activation:** Automatic during installation (Step 3)
- **Periodic Checks:** The system periodically validates the license
- **License Errors:** If the license becomes invalid, you'll see a license error page with instructions

---

## Troubleshooting

### "Whoops, Something Went Wrong" on Installation
- Ensure PHP 8.2+ is installed
- Check that all required PHP extensions are enabled
- Verify your database credentials are correct

### "Permission Denied" Errors
- Ensure `storage/` and `bootstrap/cache/` are writable (chmod 775 or 777)
- On shared hosting, use the File Manager to set permissions

### "Database Connection Refused"
- Verify the database host is correct (`127.0.0.1` or `localhost`)
- Ensure the database has been created before running the installer
- Check that your MySQL user has privileges on the database

### License Activation Failed
- Verify the License Server URL is correct and accessible
- Ensure the license key is valid and not expired
- Check your server can make outbound HTTP requests (cURL enabled)

### Application Shows Old Version After Update
- Clear browser cache
- Run: `php artisan config:clear && php artisan cache:clear`

### Storage Symlink Issues
- Run: `php artisan storage:link`
- On cPanel, ensure symlinks are enabled

---

## Included Documentation

| File | Description |
|------|-------------|
| `CLIENT_INSTALLATION.md` | This installation guide |
| `docs/Product_Inventory_Client_Documentation.md` | Full application documentation (Markdown) |
| `docs/Product_Inventory_Client_Documentation.docx` | Full application documentation (Word) |
| `INSTALLATION_GUIDE.md` | Developer installation notes |
| `README.md` | Project overview |
| `CHANGELOG.md` | Version history |
| `ARCHITECTURE.md` | Technical architecture |

---

## Support

For issues or questions, contact:

**Developer:** Md Moklesar Rahman  
**Portfolio:** https://md-moklesar-rahman-bappy.github.io/Md-Moklesar-Rahman/  
**Email:** md.moklasarrahmanbappy@gmail.com

---

*Thank you for choosing Product Inventory Dashboard!*
