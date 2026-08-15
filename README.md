# Musheeda Solutions

Production-ready IT company website and CMS.

## Features
- Dynamic landing pages
- Blog & Services management
- SEO & Media management
- Contact/lead management
- Role-based Admin panel

## Setup Instructions
1. Clone the repository.
2. Run `composer install`.
3. Copy `.env.example` to `.env` and configure your environment variables.
4. Run `php artisan key:generate`.
5. Run `php artisan migrate --seed` to setup the database.
6. Run `npm install` and `npm run dev` for frontend assets.
7. Run `php artisan serve` to start the local development server.

## Architecture & Conventions
Please refer to the following documents for project guidelines:
- [Architecture](architecture.md)
- [Coding Conventions](coding_conventions.md)
- [Database Conventions](database_conventions.md)
- [Database Schema](database_schema.md)
