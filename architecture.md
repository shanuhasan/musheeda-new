# Musheeda Solutions - Architecture Documentation

## Overview
This project uses a modular monolith architecture built on **Laravel 11**. It follows Domain-Driven Design principles loosely to keep the codebase maintainable and scalable.

## Layers
1. **Controllers**: Extremely thin. Responsible only for receiving HTTP requests, calling Services, and returning Responses.
2. **Form Requests**: Used for all validation logic.
3. **Services**: Contains all business logic (e.g., `app/Services/ContactService.php`).
4. **Repositories**: Used for complex database queries that are reused across multiple contexts (e.g., Web and API). Standard Eloquent models are used for simple queries.
5. **Policies**: Handles all authorization logic.
6. **Models**: Eloquent models representing database tables.

## Directory Structure
- `app/Services/` - Business Logic
- `app/Repositories/` - Data Access Layer for complex queries
- `app/Policies/` - Authorization
- `app/Http/Controllers/` - HTTP Request handling
- `app/Http/Requests/` - Form Validation
