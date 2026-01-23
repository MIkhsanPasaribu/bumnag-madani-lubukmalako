# BUMNAG Madani Lubukmalako

## Overview
A Laravel 11 web application running on PHP 8.4. This is a fresh Laravel installation with SQLite database for local development.

## Project Structure
- `app/` - Application code (Models, Controllers, etc.)
- `bootstrap/` - Framework bootstrap files
- `config/` - Configuration files
- `database/` - Database migrations, seeders, and SQLite database
- `public/` - Publicly accessible files
- `resources/` - Views, CSS, JavaScript source files
- `routes/` - Application routes (web.php, api.php)
- `storage/` - Logs, cache, compiled files
- `tests/` - Test files
- `vendor/` - Composer dependencies

## Development Setup
- **PHP Version**: 8.4
- **Framework**: Laravel 11
- **Database**: SQLite (database/database.sqlite)
- **Server**: PHP built-in server on port 5000

## Running the Application
The application runs automatically via the configured workflow:
```
php artisan serve --host=0.0.0.0 --port=5000
```

## Key Commands
- `php artisan migrate` - Run database migrations
- `php artisan make:controller ControllerName` - Create a new controller
- `php artisan make:model ModelName -m` - Create a model with migration
- `composer install` - Install PHP dependencies

## Configuration Notes
- Trusted proxies are configured to trust all proxies (required for Replit's proxy environment)
- Application binds to 0.0.0.0 to be accessible through Replit's webview
