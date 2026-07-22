# Deployment Guide

This guide covers deploying Product Inventory to a production server.

## Table of Contents

- [Server Requirements](#server-requirements)
- [Deployment Steps](#deployment-steps)
- [Web Server Configuration](#web-server-configuration)
- [Queue Workers](#queue-workers)
- [Cron Jobs](#cron-jobs)
- [SSL / HTTPS](#ssl--https)
- [Optimization](#optimization)
- [File Permissions](#file-permissions)
- [Post-Deployment Checklist](#post-deployment-checklist)

## Server Requirements

### Minimum Specifications

| Resource | Requirement |
|---|---|
| **OS** | Ubuntu 22.04 LTS / Debian 12 / RHEL 9 |
| **PHP** | 8.2.0+ with all required extensions |
| **MySQL** | 8.0+ |
| **Web Server** | Nginx 1.18+ or Apache 2.4+ |
| **Composer** | 2.x |
| **Memory** | 512MB RAM minimum |
| **Disk** | 2GB free space |

### Required PHP Extensions

```
mbstring, openssl, pdo, pdo_mysql, curl, json, fileinfo, gd, xml, zip, bcmath, tokenizer
```

### Install PHP Extensions (Ubuntu/Debian)

```bash
sudo apt update
sudo apt install php8.2-cli php8.2-mbstring php8.2-xml php8.2-curl \
    php8.2-gd php8.2-zip php8.2-bcmath php8.2-mysql php8.2-tokenizer
```

## Deployment Steps

### 1. Clone or Upload the Repository

```bash
cd /var/www
sudo git clone https://github.com/your-username/product_inventory.git
cd product_inventory
```

### 2. Install Dependencies (Production)

```bash
composer install --no-dev --optimize-autoloader
```

This excludes dev dependencies (Faker, Pest, Pint, etc.) and optimizes the autoloader.

### 3. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` for production:

```env
APP_NAME="Product Inventory"
APP_ENV=production
APP_KEY=base64:GENERATED_KEY
APP_DEBUG=false
APP_URL=https://inventory.yourdomain.com
APP_TIMEZONE=Asia/Dhaka

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_inventory
DB_USERNAME=product_inventory_user
DB_PASSWORD=your-secure-database-password

LICENSE_SERVER_URL=https://license-server.com/api/verify
LICENSE_PRODUCT_ID=your-product-id
LICENSE_APP_VERSION=1.0.0
LICENSE_CHECK_INTERVAL_DAYS=7
LICENSE_OFFLINE_GRACE_DAYS=14
LICENSE_REQUEST_TIMEOUT=10
LICENSE_API_KEY=your-api-key

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=mail@yourdomain.com
MAIL_PASSWORD=your-mail-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="Product Inventory"
```

### 4. Create the Database

```bash
mysql -u root -p -e "CREATE DATABASE product_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
mysql -u root -p -e "CREATE USER 'product_inventory_user'@'127.0.0.1' IDENTIFIED BY 'your-secure-database-password'"
mysql -u root -p -e "GRANT ALL PRIVILEGES ON product_inventory.* TO 'product_inventory_user'@'127.0.0.1'"
mysql -u root -p -e "FLUSH PRIVILEGES"
```

### 5. Run Migrations

```bash
php artisan migrate --force
```

### 6. Create Storage Link

```bash
php artisan storage:link
```

### 7. Set File Permissions

```bash
# Set ownership to web server user
sudo chown -R www-data:www-data /var/www/product_inventory

# Set directory permissions
sudo find /var/www/product_inventory -type d -exec chmod 755 {} \;

# Set file permissions
sudo find /var/www/product_inventory -type f -exec chmod 644 {} \;

# Writable directories
sudo chmod -R 775 /var/www/product_inventory/storage
sudo chmod -R 775 /var/www/product_inventory/bootstrap/cache

# Web server write access
sudo setfacl -R -m u:www-data:rwX -m u:www-data:rwX /var/www/product_inventory/storage
sudo setfacl -R -m u:www-data:rwX -m u:www-data:rwX /var/www/product_inventory/bootstrap/cache
```

### 8. Run the Installer Wizard

Open `https://inventory.yourdomain.com` in your browser. The installer wizard will:
1. Verify server requirements
2. Confirm database connection (already configured)
3. Validate license
4. Create the Superadmin account
5. Complete installation

## Web Server Configuration

### Nginx

```nginx
server {
    listen 80;
    server_name inventory.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name inventory.yourdomain.com;
    root /var/www/product_inventory/public;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/inventory.yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/inventory.yourdomain.com/privkey.pem;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    # Laravel Routing
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP Processing
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realroot$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    # Deny Hidden Files
    location ~ /\. {
        deny all;
    }

    # Static Assets Cache
    location ~* \.(css|js|ico|gif|jpeg|jpg|png|woff|woff2|ttf|svg|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

Enable the site:

```bash
sudo ln -s /etc/nginx/sites-available/product_inventory /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Apache

Ensure `mod_rewrite` is enabled:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Create the virtual host:

```apache
<VirtualHost *:443>
    ServerName inventory.yourdomain.com
    DocumentRoot /var/www/product_inventory/public

    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/inventory.yourdomain.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/inventory.yourdomain.com/privkey.pem

    <Directory /var/www/product_inventory/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/product_inventory_error.log
    CustomLog ${APACHE_LOG_DIR}/product_inventory_access.log combined
</VirtualHost>

<VirtualHost *:80>
    ServerName inventory.yourdomain.com
    Redirect permanent / https://inventory.yourdomain.com/
</VirtualHost>
```

The `.htaccess` in `public/` handles Laravel's URL rewriting. Ensure it contains:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## Queue Workers

Product Inventory uses Laravel's queue system for background jobs (email sending, credential delivery, etc.).

### Database Queue Driver

If using `QUEUE_CONNECTION=database`:

```bash
# Start the queue worker
php artisan queue:work --sleep=3 --tries=3 --max-time=3600
```

### Supervisor Configuration

For persistent queue workers, use Supervisor:

```bash
sudo apt install supervisor
```

Create `/etc/supervisor/conf.d/product-inventory-worker.conf`:

```ini
[program:product-inventory-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/product_inventory/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/product_inventory/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start product-inventory-worker:*
```

## Cron Jobs

Laravel's task scheduler requires a single cron entry:

```bash
crontab -e
```

Add:

```bash
* * * * * cd /var/www/product_inventory && php artisan schedule:run >> /dev/null 2>&1
```

This runs every minute and executes any scheduled tasks defined in `routes/console.php`.

## SSL / HTTPS

### Let's Encrypt (Recommended)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d inventory.yourdomain.com

# Auto-renewal
sudo certbot renew --dry-run
```

For Apache:

```bash
sudo apt install certbot python3-certbot-apache
sudo certbot --apache -d inventory.yourdomain.com
```

### Force HTTPS

In `.env`:

```env
APP_URL=https://inventory.yourdomain.com
```

The Nginx/Apache configuration above handles HTTP → HTTPS redirects.

## Optimization

### Laravel Optimization Commands

```bash
# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Optimize autoloader (done by composer install --optimize-autoloader)
composer dump-autoload --optimize --no-dev
```

### Combined Optimization Script

```bash
#!/bin/bash
cd /var/www/product_inventory
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
composer dump-autoload --optimize --no-dev
echo "Optimization complete."
```

## File Permissions

| Path | Permissions | Owner | Purpose |
|---|---|---|---|
| `/var/www/product_inventory` | `755` | `www-data` | Application root |
| `storage/` | `775` | `www-data` | Logs, cache, uploads |
| `bootstrap/cache/` | `775` | `www-data` | Framework cache |
| `.env` | `640` | `www-data` | Environment config |
| `public/` | `755` | `www-data` | Web root |

## Post-Deployment Checklist

- [ ] `APP_ENV=production` is set in `.env`
- [ ] `APP_DEBUG=false` is set in `.env`
- [ ] `APP_URL` uses HTTPS
- [ ] Strong `APP_KEY` is generated
- [ ] Database credentials are secure and unique
- [ ] `.env` file is not publicly accessible
- [ ] All Laravel caches are warmed (`config:cache`, `route:cache`, `view:cache`)
- [ ] Storage symlink exists (`storage:link`)
- [ ] Queue worker is running via Supervisor
- [ ] Cron job is configured for task scheduler
- [ ] SSL certificate is installed and auto-renewing
- [ ] File permissions are correct (especially `storage/` and `bootstrap/cache/`)
- [ ] Email (SMTP) is configured and working
- [ ] License server URL and API key are correct
- [ ] Error logging is configured (`storage/logs/laravel.log` is writable)
- [ ] HTTP security headers are set (X-Frame-Options, X-Content-Type-Options)
- [ ] Removed installer route access after installation
- [ ] Database backups are configured
- [ ] Monitor logs for errors: `tail -f storage/logs/laravel.log`
