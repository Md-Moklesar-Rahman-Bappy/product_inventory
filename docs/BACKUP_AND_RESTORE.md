# Backup and Restore

## Database Backup
Use placeholder commands (replace with real credentials only in a secure environment):
```bash
mysqldump -u <DB_USERNAME> -p <DB_DATABASE> > backup_$(date +%Y%m%d_%H%M%S).sql
```
For compressed backups:
```bash
mysqldump -u <DB_USERNAME> -p <DB_DATABASE> | gzip > backup_$(date +%Y%m%d_%H%M%S).sql.gz
```

## Uploaded Product Images / Storage Files
```bash
tar -czvf storage_backup_$(date +%Y%m%d_%H%M%S).tar.gz storage/app/public public/storage
```

## Environment Configuration
Back up `.env` (after ensuring no secrets are committed):
```bash
cp .env .env.backup_$(date +%Y%m%d_%H%M%S)
```
**Do not include `.env` in release archives.** Only `.env.example` should be distributed.

## Restoration
1. Restore the database:
   ```bash
   mysql -u <DB_USERNAME> -p <DB_DATABASE> < backup_YYYYMMDD_HHMMSS.sql
   ```
2. Restore storage files:
   ```bash
   tar -xzvf storage_backup_YYYYMMDD_HHMMSS.tar.gz
   ```
3. Restore `.env` from backup (rotate any exposed keys after restoration):
   ```bash
   cp .env.backup_YYYYMMDD .env
   ```

## Post-Restore Cache Clearing
```bash
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan storage:link
```

## Post-Restore Verification
- Log in with an administrator account.
- Verify a product with Bangla text displays correctly.
- Run import/export smoke tests.
- Check `position` shows text (not `0`).
