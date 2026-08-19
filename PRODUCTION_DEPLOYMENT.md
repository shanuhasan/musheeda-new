# Musheeda Solutions - Production Deployment Guide

This document outlines the necessary steps, requirements, and best practices for deploying the Musheeda Solutions application to a production environment.

## 1. Server Requirements

Ensure your server meets the following requirements:
* **PHP:** `^8.2`
* **Web Server:** Nginx or Apache (Nginx recommended)
* **Database:** MySQL 8.0+ or PostgreSQL 12+
* **Required PHP Extensions:**
  * Ctype, cURL, DOM, Fileinfo, Filter, Hash, Mbstring, OpenSSL, PCRE, PDO, Session, Tokenizer, XML, BCMath, JSON
* **Node.js:** `^18.0` (for building assets)
* **Composer:** `^2.2`

## 2. Environment Setup

### Never Expose `.env`
The `.env` file contains sensitive information like database credentials and API keys.
* **CRITICAL:** Ensure `.env` is never committed to the repository. It is included in `.gitignore` by default.
* Generate a new application key on the production server:
  ```bash
  php artisan key:generate
  ```

### Update Configuration Variables
Ensure the following variables are strictly set in your production `.env`:
* `APP_ENV=production` (Critical: Disables local environment behaviors)
* `APP_DEBUG=false` (Critical: Prevents detailed exceptions and stack traces from being shown to users)
* `APP_URL=https://yourdomain.com` (Ensure it uses `https://`)
* `SESSION_SECURE_COOKIE=true`
* `SESSION_HTTP_ONLY=true`
* `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` (Your production DB credentials)

## 3. Database Setup & Migration Strategy

* Create the production database and user with appropriate permissions.
* Run migrations with the `--force` flag to bypass the production confirmation prompt:
  ```bash
  php artisan migrate --force
  ```
* **Migration Strategy:** Always test migrations on a staging environment that mirrors production data before running them on the live database.

## 4. Build Process

* Install PHP dependencies without dev packages:
  ```bash
  composer install --optimize-autoloader --no-dev
  ```
* Install Node dependencies and build assets:
  ```bash
  npm install
  npm run build
  ```

## 5. Storage Linking & Permissions

* Link the storage directory so public assets can be accessed:
  ```bash
  php artisan storage:link
  ```
* Ensure the web server user (e.g., `www-data` or `nginx`) has write permissions to the `storage/` and `bootstrap/cache/` directories:
  ```bash
  chown -R www-data:www-data storage bootstrap/cache
  chmod -R 775 storage bootstrap/cache
  ```

## 6. Cache Optimization

Laravel provides commands to heavily optimize the framework in production. Run these during your deployment script:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```
*Note: Whenever you change configuration, routes, or environment variables, you must re-run these commands or run `php artisan optimize:clear`.*

## 7. Queue Worker & Scheduler Configuration

### Queue Worker
If using queues (e.g., `QUEUE_CONNECTION=database` or `redis`), configure a process monitor like Supervisor to keep the worker running:
```ini
[program:musheeda-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/project/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/project/storage/logs/worker.log
```

### Scheduled Tasks (Cron Job)
Add a single cron entry to your server to run Laravel's scheduler every minute:
```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

## 8. Security Audits

* **HTTPS:** Enforce HTTPS at the web server level (e.g., Nginx `listen 443 ssl`, redirect port 80).
* **Security Headers:** The application includes a `SecurityHeaders` middleware that automatically injects `X-Frame-Options`, `X-Content-Type-Options`, `Strict-Transport-Security`, and `Content-Security-Policy`.
* **Error Handling:** With `APP_DEBUG=false`, standard HTTP 500 error pages are shown to users instead of sensitive stack traces. Errors are logged securely in `storage/logs/laravel.log`.

## 9. Backup & Monitoring Strategy

* **Database Backups:** Use a tool like `spatie/laravel-backup` or a server-level cron job (e.g., `mysqldump`) to back up the database daily. Store backups securely off-site (e.g., AWS S3).
* **Application Monitoring:** Integrate an error tracking service like Sentry or Flare to monitor exceptions in real-time. Set `LOG_CHANNEL=daily` or use a centralized logging service.
