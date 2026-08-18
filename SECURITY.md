# Security Policy

At Musheeda Solutions, we take the security of our application and user data seriously. This document outlines the security measures in place, our disclosure policy, and recommendations for a secure production environment.

## Supported Versions

Currently, the `main` branch of Musheeda Solutions is actively supported with security updates.

| Version | Supported          |
| ------- | ------------------ |
| 1.x     | :white_check_mark: |
| < 1.0   | :x:                |

## Reporting a Vulnerability

If you discover a security vulnerability within Musheeda Solutions, please send an e-mail to our security team at `security@musheeda.com`. All security vulnerabilities will be promptly addressed.

Please include the following information in your report:
- A description of the vulnerability.
- Steps to reproduce the vulnerability.
- Any potential impact on the application or its users.

## Security Practices Implemented

During our security audits, we have strictly adhered to best practices, implementing mitigations against the OWASP Top 10 vulnerabilities:

### 1. Cross-Site Scripting (XSS) Mitigation
- **HTML Purifier:** All user-generated content, especially rich-text areas like blog posts, pages, services, and products, are sanitized using HTML Purifier (`Mews\Purifier\Facades\Purifier::clean`) before being outputted in Blade templates. This prevents execution of malicious JavaScript.
- **Blade Templating Engine:** Default `{{ }}` tags are used universally for variables not containing HTML, automatically escaping them.

### 2. Broken Access Control Mitigation
- **Strict Role-Based Access Control (RBAC):** Admin routes are protected using `Spatie\Permission` middleware via Laravel's native Authorization gates (`can:permission_name`). 
    - Settings, Advertisements, and Menus are strictly restricted to users with `manage_settings` permission.
    - Editors and Authors can only manage content (Pages, Blogs, Media) as per their explicitly assigned permissions.
    - Direct access or IDOR (Insecure Direct Object Reference) attempts are prevented by verifying permissions at the route layer.

### 3. File Upload Security
- **MIME Type Validation:** The Media Library strictly enforces `mimes` validation on uploads (`jpg, jpeg, png, gif, webp, pdf, doc, docx, xls, xlsx`).
- **SVG Restriction:** `.svg` file uploads have been disabled by default to prevent XSS attacks through embedded JavaScript in vectors.

### 4. Session & CSRF Security
- **Secure Sessions:** Sessions are stored in the database for better integrity and invalidation tracking.
- **CSRF Protection:** All non-GET requests are verified using Laravel's native `@csrf` protection mechanism.
- **Secure Cookies:** `SESSION_SECURE_COOKIE=true` and `SESSION_HTTP_ONLY=true` are configured to ensure session cookies are only transmitted over HTTPS and inaccessible to client-side scripts.

### 5. SQL Injection & Mass Assignment
- **Eloquent ORM:** Raw SQL queries are strictly avoided. We rely exclusively on Laravel's Eloquent ORM and Query Builder, taking advantage of PDO parameter binding to prevent SQL injections.
- **Mass Assignment:** All models utilize the `$fillable` property to strictly define which attributes can be mass-assigned, protecting critical properties (e.g., `role`, `id`) from unauthorized modification.

### 6. Spam & Abuse Protection
- **Honeypot:** Public forms (Leads, Contact, Newsletter) implement honeypot fields to silently drop automated bot submissions.
- **Rate Limiting:** Aggressive rate limiting is implemented on sensitive endpoints (e.g., login, lead submission, newsletter subscription) using Laravel's `throttle` middleware to prevent brute force and spam attacks.

## Production Deployment Recommendations

When deploying Musheeda Solutions to production, it is vital to ensure the environment is configured securely:

1. **Disable Debug Mode:** Ensure `APP_DEBUG=false` in your `.env` file to prevent sensitive stack traces and environment variables from being exposed on error screens.
2. **Enforce HTTPS:** Ensure your web server (Nginx/Apache) redirects all HTTP traffic to HTTPS.
3. **Secure Headers:** Implement security headers at the web server level, including:
   - `Strict-Transport-Security` (HSTS)
   - `X-Frame-Options: SAMEORIGIN`
   - `X-Content-Type-Options: nosniff`
   - `Referrer-Policy: strict-origin-when-cross-origin`
4. **Environment Variables:** Keep your `.env` file outside the public document root and restrict read/write access. Do not commit it to version control.
5. **Keep Dependencies Updated:** Regularly run `composer audit` and `npm audit` to check for known vulnerabilities in third-party packages, and update accordingly.
6. **File Permissions:** Ensure the `storage` and `bootstrap/cache` directories are writable by your web server, but restrict permissions for other application files (e.g., `755` for directories, `644` for files).

---
*Documented as part of Phase 19 Security Audit.*
