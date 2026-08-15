# Musheeda Solutions - Coding Conventions

1. **SOLID Principles**: Adhere to Single Responsibility, Open-Closed, Liskov Substitution, Interface Segregation, and Dependency Inversion.
2. **Naming Conventions**:
   - Variables/Properties: `camelCase`
   - Methods: `camelCase`
   - Classes/Interfaces: `PascalCase`
   - Database Tables: `snake_case` (plural)
   - Database Columns: `snake_case`
3. **Typing**: Use strict typing (`declare(strict_types=1);` is recommended where practical) and always specify return types and parameter types for all methods.
4. **Validation**: NEVER validate inside controllers. Always use Form Requests (`php artisan make:request`).
5. **Fat Models, Skinny Controllers**: Push business logic to Services, and query scopes/relationships to Models. Controllers should not exceed 5-10 lines of code per method.
6. **No N+1 Queries**: Always use `with()` to eager load relationships when querying a list of items.
7. **Security**: Passwords must always be hashed. Avoid mass assignment vulnerabilities by carefully defining `$fillable`.
