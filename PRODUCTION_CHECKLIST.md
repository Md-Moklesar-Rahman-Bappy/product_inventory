# Production Deployment Checklist

Use this comprehensive checklist before and after deploying Product Inventory to production.

## Environment Configuration

- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_KEY` is set and is 32+ character base64 string
- [ ] `APP_URL` uses `https://` protocol
- [ ] `APP_TIMEZONE=Asia/Dhaka` (or appropriate timezone)
- [ ] `.env` file exists and is not committed to version control
- [ ] `.env` permissions are `640` (readable only by web server user)

## Database

- [ ] Production database is created with `utf8mb4` charset
- [ ] Dedicated database user with minimal required privileges
- [ ] `DB_PASSWORD` is a strong, unique password
- [ ] All migrations have been run (`php artisan migrate --force`)
- [ ] Database backups are scheduled (daily minimum)
- [ ] Backup restoration has been tested
- [ ] Remote database access is restricted to application server only

## Security

- [ ] `APP_DEBUG=false` (prevents stack trace exposure)
- [ ] `SESSION_SECURE_COOKIE=true` (HTTPS-only cookies)
- [ ] `SESSION_HTTP_ONLY=true` (no JavaScript access to cookies)
- [ ] Strong `APP_KEY` (never reuse development keys)
- [ ] `.env` is not in the web root's served directory
- [ ] `.gitignore` excludes `.env`, `vendor/`, `node_modules/`
- [ ] License server API key is set and valid
- [ ] License server URL uses HTTPS
- [ ] HTTP security headers configured:
  - [ ] `X-Frame-Options: SAMEORIGIN`
  - [ ] `X-Content-Type-Options: nosniff`
  - [ ] `X-XSS-Protection: 1; mode=block`
  - [ ] `Referrer-Policy: strict-origin-when-cross-origin`
  - [ ] `Content-Security-Policy` (as appropriate)
- [ ] Composer dependencies installed with `--no-dev --optimize-autoloader`
- [ ] No dev/debug packages in production (Pint, Pail, Telescope, etc.)
- [ ] File upload size limits configured in `php.ini`
- [ ] SQL injection prevention verified (Eloquent parameterized queries used)
- [ ] CSRF protection is enabled (default in Laravel)
- [ ] Email verification is enforced for new users

## Performance

- [ ] Configuration cached: `php artisan config:cache`
- [ ] Routes cached: `php artisan route:cache`
- [ ] Views cached: `php artisan view:cache`
- [ ] Events cached: `php artisan event:cache`
- [ ] Autoloader optimized: `composer dump-autoload --optimize --no-dev`
- [ ] OPcache enabled in `php.ini`:
  ```ini
  opcache.enable=1
  opcache.memory_consumption=128
  opcache.max_accelerated_files=10000
  opcache.validate_timestamps=0
  ```
- [ ] MySQL query cache configured
- [ ] Static assets served via CDN or with proper cache headers
- [ ] Gzip/Brotli compression enabled on web server
- [ ] `APP_DEBUG=false` (prevents debug bar and extra queries)

## Queue Workers

- [ ] Queue driver configured (`QUEUE_CONNECTION=database` recommended)
- [ ] Queue worker running via Supervisor or systemd
- [ ] Worker process auto-restarts on failure
- [ ] Worker log file is configured and monitored
- [ ] Worker restarts after deployments:
  ```bash
  php artisan queue:restart
  ```

### Supervisor Configuration

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

## Cron Jobs

- [ ] Task scheduler cron job is installed:
  ```bash
  * * * * * cd /var/www/product_inventory && php artisan schedule:run >> /dev/null 2>&1
  ```
- [ ] Cron job has been tested and is running

## File Permissions

- [ ] Application directory owned by `www-data:www-data`
- [ ] `storage/` directory: `775` and writable by web server
- [ ] `bootstrap/cache/` directory: `775` and writable by web server
- [ ] `public/storage` symlink exists:
  ```bash
  php artisan storage:link
  ```
- [ ] No `777` permissions anywhere in the application
- [ ] `.htaccess` exists in `public/` for Apache URL rewriting

### Permission Commands

```bash
sudo chown -R www-data:www-data /var/www/product_inventory
sudo find /var/www/product_inventory -type d -exec chmod 755 {} \;
sudo find /var/www/product_inventory -type f -exec chmod 644 {} \;
sudo chmod -R 775 /var/www/product_inventory/storage
sudo chmod -R 775 /var/www/product_inventory/bootstrap/cache
```

## Logging

- [ ] `LOG_CHANNEL=stack` (or `daily` for file rotation)
- [ ] `LOG_LEVEL=warning` or `error` (not `debug` in production)
- [ ] `storage/logs/` directory is writable
- [ ] Log rotation configured (Laravel daily driver auto-rotates)
- [ ] Error monitoring in place (Sentry, Bugsnag, or similar)
- [ ] No sensitive data logged (passwords, API keys, tokens)

## Error Handling

- [ ] Custom error pages configured (403, 404, 500)
- [ ] `APP_DEBUG=false` shows generic error page, not stack traces
- [ ] `storage/logs/laravel.log` is monitored for errors
- [ ] Exception notifications configured (optional)

## SSL / HTTPS

- [ ] SSL certificate installed (Let's Encrypt or commercial)
- [ ] Certificate auto-renewal configured:
  ```bash
  sudo certbot renew --dry-run
  ```
- [ ] HTTP → HTTPS redirect configured in web server
- [ ] HSTS header configured (optional):
  ```nginx
  add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
  ```

## Mail Configuration

- [ ] SMTP credentials are correct
- [ ] Test email sent and received successfully
- [ ] Email verification flow tested end-to-end
- [ ] Credential notification email tested
- [ ] `MAIL_FROM_ADDRESS` is valid and from your domain

## License Verification

- [ ] `LICENSE_SERVER_URL` is correct and uses HTTPS
- [ ] `LICENSE_PRODUCT_ID` matches the registered product
- [ ] `LICENSE_API_KEY` is set and valid
- [ ] `LICENSE_APP_VERSION` matches current version
- [ ] `LICENSE_CHECK_INTERVAL_DAYS` is appropriate (7 recommended)
- [ ] `LICENSE_OFFLINE_GRACE_DAYS` is configured (14 recommended)
- [ ] License verification has been tested successfully

## Monitoring

- [ ] Application logs are being collected
- [ ] Server resource monitoring (CPU, RAM, disk)
- [ ] Database performance monitoring
- [ ] Uptime monitoring (UptimeRobot, Pingdom, etc.)
- [ ] Alert notifications configured for errors and downtime

## Backup Strategy

- [ ] Database backup scheduled (daily minimum):
  ```bash
  mysqldump -u root -p product_inventory > backup_$(date +%Y%m%d).sql
  ```
- [ ] `storage/` directory backed up (profile photos, logs)
- [ ] `.env` configuration backed up securely
- [ ] Backup restoration tested and verified
- [ ] Off-site backup storage configured
- [ ] Backup retention policy defined (e.g., keep 30 days)

### Automated Backup Script

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/product_inventory"
DB_NAME="product_inventory"
DB_USER="root"

mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Storage backup
tar -czf $BACKUP_DIR/storage_$DATE.tar.gz /var/www/product_inventory/storage/app/

# Remove backups older than 30 days
find $BACKUP_DIR -type f -mtime +30 -delete
```

## Post-Deployment Verification

- [ ] Homepage loads without errors
- [ ] Login page is accessible
- [ ] Admin login works with created credentials
- [ ] Dashboard displays correct statistics
- [ ] Product listing loads with data
- [ ] CRUD operations work (create, read, update, delete)
- [ ] Excel import/export functions correctly
- [ ] File uploads work (profile photos)
- [ ] Activity logs are being recorded
- [ ] Email verification sends correctly
- [ ] Maintenance tracking works
- [ ] Warranty overview displays correctly
- [ ] Installer wizard no longer accessible (redirects to login)
- [ ] No errors in `storage/logs/laravel.log`
- [ ] Queue worker processes jobs successfully
- [ ] Cron job runs on schedule

## Deployment Rollback Plan

1. Keep the previous release's code available
2. Document the rollback steps:
   ```bash
   # Rollback code
   cd /var/www/product_inventory
   git checkout <previous-tag>

   # Clear caches
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache

   # Restart queue workers
   php artisan queue:restart
   ```
3. If database migrations were run, prepare reverse migrations
4. Test rollback in staging environment first
