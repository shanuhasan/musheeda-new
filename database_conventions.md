# Musheeda Solutions - Database Conventions

1. **Database System**: Defaulting to SQLite for local development; MySQL/PostgreSQL for production.
2. **Migrations**: All database schema changes MUST be done via migrations. Never modify the database directly.
3. **Primary Keys**: Use `id` (bigIncrements/ulid/uuid).
4. **Foreign Keys**: Always define foreign keys with proper constraints (`constrained()->cascadeOnDelete()` where applicable) to maintain referential integrity.
5. **Soft Deletes**: Use SoftDeletes for critical data (users, blog posts, leads) to prevent accidental data loss.
6. **Timestamps**: All tables (except pivot tables) must have `created_at` and `updated_at`.
7. **Indexing**: Add indexes on columns that are frequently used in `WHERE`, `ORDER BY`, or `JOIN` clauses (e.g., `slug`, `email`, `status`).
