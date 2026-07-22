# Environment Variables Reference

Complete reference for all `.env` configuration variables in Product Inventory.

> After changing environment variables, run `php artisan config:clear` to apply.

## Application

| Variable | Default | Description |
|---|---|---|
| `APP_NAME` | `"Product Inventory"` | Application name displayed in UI and emails |
| `APP_ENV` | `local` | Environment mode: `local`, `production`, `testing` |
| `APP_KEY` | — | 32-character encryption key (generated via `php artisan key:generate`) |
| `APP_DEBUG` | `true` | Enable debug mode. **Must be `false` in production** |
| `APP_URL` | `http://localhost` | Base URL of the application (no trailing slash) |
| `APP_TIMEZONE` | `Asia/Dhaka` | Default timezone for all date/time operations |
| `APP_LOCALE` | `en` | Default locale for localization |
| `APP_FALLBACK_LOCALE` | `en` | Fallback locale when requested locale is unavailable |
| `APP_MAINTENANCE_DRIVER` | `file` | Maintenance mode driver: `file`, `cache` |

## Database

| Variable | Default | Description |
|---|---|---|
| `DB_CONNECTION` | `mysql` | Database driver: `mysql`, `sqlite`, `pgsql`, `mariadb` |
| `DB_HOST` | `127.0.0.1` | Database server hostname or IP address |
| `DB_PORT` | `3306` | Database server port |
| `DB_DATABASE` | `product_inventory` | Database name |
| `DB_USERNAME` | `root` | Database authentication username |
| `DB_PASSWORD` | — | Database authentication password |
| `DB_UNIX_SOCKET` | — | Unix socket for database connection (optional) |
| `DB_CHARSET` | `utf8mb4` | Database character set |
| `DB_COLLATION` | `utf8mb4_unicode_ci` | Database collation |
| `DB_PREFIX` | — | Table prefix for all database tables |

## Session

| Variable | Default | Description |
|---|---|---|
| `SESSION_DRIVER` | `file` | Session storage driver: `file`, `cookie`, `database`, `redis`, `array` |
| `SESSION_LIFETIME` | `120` | Session lifetime in minutes |
| `SESSION_ENCRYPT` | `false` | Whether to encrypt session data |
| `SESSION_PATH` | `/` | Session cookie path |
| `SESSION_DOMAIN` | — | Session cookie domain (null = current domain) |
| `SESSION_SECURE_COOKIE` | — | Force HTTPS for cookies (null = auto-detect) |
| `SESSION_HTTP_ONLY` | `true` | Restrict cookies to HTTP only (no JavaScript access) |
| `SESSION_PARTITIONED` | `false` | Partition cookies for cross-site isolation |

## Cache

| Variable | Default | Description |
|---|---|---|
| `CACHE_STORE` | `file` | Cache driver: `file`, `database`, `redis`, `memcached`, `array` |
| `CACHE_PREFIX` | `laravel` | Cache key prefix to avoid collisions |

## Queue

| Variable | Default | Description |
|---|---|---|
| `QUEUE_CONNECTION` | `sync` | Queue driver: `sync` (immediate), `database`, `redis`, `sqs`, `beanstalkd` |
| `QUEUE_FAILED_DRIVER` | `database-uuids` | Driver for tracking failed jobs |
| `QUEUE_FAILED_TABLE` | `failed_jobs` | Database table for failed jobs |

## Mail

| Variable | Default | Description |
|---|---|---|
| `MAIL_MAILER` | `log` | Mail transport: `smtp`, `sendmail`, `mailgun`, `ses`, `postmark`, `log` |
| `MAIL_HOST` | `127.0.0.1` | SMTP server hostname |
| `MAIL_PORT` | `2525` | SMTP server port |
| `MAIL_USERNAME` | — | SMTP authentication username |
| `MAIL_PASSWORD` | — | SMTP authentication password |
| `MAIL_ENCRYPTION` | `ssl` | Encryption: `ssl`, `tls`, or `null` |
| `MAIL_FROM_ADDRESS` | `hello@product-inventory.dev` | Sender email address |
| `MAIL_FROM_NAME` | `${APP_NAME}` | Sender display name |

## Redis

| Variable | Default | Description |
|---|---|---|
| `REDIS_HOST` | `127.0.0.1` | Redis server hostname |
| `REDIS_PASSWORD` | — | Redis server password (null for no auth) |
| `REDIS_PORT` | `6379` | Redis server port |
| `REDIS_CLIENT` | `phpredis` | Redis client: `phpredis`, `predis` |
| `REDIS_CACHE_DB` | `1` | Redis database number for cache |

## Logging

| Variable | Default | Description |
|---|---|---|
| `LOG_CHANNEL` | `stack` | Log channel: `single`, `daily`, `stack`, `stderr`, `syslog` |
| `LOG_STACK` | `single` | Channels included in the stack driver |
| `LOG_DEPRECATIONS_CHANNEL` | `null` | Channel for deprecation warnings |
| `LOG_LEVEL` | `debug` | Minimum log level: `debug`, `info`, `notice`, `warning`, `error`, `critical`, `alert`, `emergency` |

## License

These variables configure the license verification system that validates the application against a remote license server.

| Variable | Default | Description |
|---|---|---|
| `LICENSE_SERVER_URL` | — | Full URL of the license dashboard server (e.g., `https://license.example.com/api/verify`) |
| `LICENSE_PRODUCT_ID` | — | Unique product identifier registered on the license server |
| `LICENSE_APP_VERSION` | `1.0.0` | Application version string sent during license verification |
| `LICENSE_CHECK_INTERVAL_DAYS` | `7` | How often (in days) the application contacts the license server for re-validation |
| `LICENSE_OFFLINE_GRACE_DAYS` | `14` | Number of days the application continues to function if the license server is unreachable |
| `LICENSE_REQUEST_TIMEOUT` | `10` | HTTP request timeout in seconds for license server communication |
| `LICENSE_API_KEY` | — | API key for authenticating requests to the license server |

### License Behavior

1. On each request (or at the configured interval), `VerifyLicenseMiddleware` contacts the license server
2. The server validates the product ID, version, and API key
3. If validation succeeds, the license state is cached locally
4. If the server is unreachable, the application uses cached state for up to `LICENSE_OFFLINE_GRACE_DAYS` days
5. After the grace period expires, the application requires re-verification before serving requests

## Filesystem

| Variable | Default | Description |
|---|---|---|
| `FILESYSTEM_DISK` | `local` | Default filesystem driver: `local`, `public`, `s3` |
| `FILESYSTEM_VISIBILITY` | `public` | Default file visibility: `public`, `private` |

## Broadcasting

| Variable | Default | Description |
|---|---|---|
| `BROADCAST_DRIVER` | `log` | Broadcasting driver: `pusher`, `ably`, `redis`, `log` |

## Example Full `.env`

```env
APP_NAME="Product Inventory"
APP_ENV=local
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_TIMEZONE=Asia/Dhaka

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_inventory
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
SESSION_LIFETIME=120

CACHE_STORE=file

QUEUE_CONNECTION=sync

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@product-inventory.dev"
MAIL_FROM_NAME="${APP_NAME}"

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=debug

LICENSE_SERVER_URL=https://license.example.com/api/verify
LICENSE_PRODUCT_ID=product-inventory-001
LICENSE_APP_VERSION=1.0.0
LICENSE_CHECK_INTERVAL_DAYS=7
LICENSE_OFFLINE_GRACE_DAYS=14
LICENSE_REQUEST_TIMEOUT=10
LICENSE_API_KEY=your-api-key-here
```
