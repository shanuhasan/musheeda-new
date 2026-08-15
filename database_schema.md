# Database Schema Documentation

## Core Entities
1. **users**
   - Stores all application users, admins, and authors.
   - Includes `status` (active/inactive) and `softDeletes()`.
   - Has many Roles/Permissions via Spatie.

2. **settings**
   - Unified key-value store for company and website settings.
   - `group` column allows grouping (e.g., 'company', 'social', 'website').
   - `type` column allows frontend to render correct input (text, boolean, image).

3. **navigation_menus & navigation_menu_items**
   - `navigation_menus`: Defines the menu locations (e.g., 'header', 'footer').
   - `navigation_menu_items`: The actual links. Supports unlimited nesting via `parent_id`.

4. **pages**
   - Standard CMS pages (About, Terms, etc.).
   - Relates to `users` (author_id).
   - Polymorphic relation to `seo_metadata` and `media`.

5. **contact_submissions**
   - Stores leads from the website.
   - Includes `status` (unread, read) and `read_at` timestamp.

6. **newsletter_subscribers**
   - Stores email subscriptions.
   - Tracks `status` (subscribed, unsubscribed) and verification timestamp.

7. **redirects**
   - Handles 301/302 SEO redirects from old URLs to new URLs.

8. **seo_metadata**
   - Polymorphic table storing meta title, description, keywords, etc., for any model (Pages, Services, Posts).

9. **roles & permissions**
   - Managed via `spatie/laravel-permission`.

10. **media**
    - Managed via `spatie/laravel-medialibrary`. Polyphormic file storage.
