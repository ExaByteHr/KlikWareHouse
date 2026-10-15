# Agent Guidelines & Repository Context

## Project Overview
- Name: Inventoros
- Application: Laravel 13 multi-tenant application with Inertia.js v3, Vue 3, and Tailwind CSS.
- Build Tool: Vite 7

## Environment & Services
- PHP: 8.4.x CLI
- Node.js: 22.x LTS (npm)
- Database: MySQL 8.0 (Host: `127.0.0.1`, Port: `3306`, DB: `inventoros`, User: `inventoros`, Pass: `secret`)
  - If MySQL service stops between task runs, start it with: `sudo service mysql start`

## Standard Workflows & Commands

### Code Quality & Formatting
- Check PHP code style: `./vendor/bin/pint --test`
- Fix PHP code style: `./vendor/bin/pint`

### Database Migrations
- Run migrations: `php artisan migrate`
- Fresh migration with seeders (when clean state needed): `php artisan migrate:fresh --seed`

### Testing
- Run full test suite: `composer test` (or `php artisan test`)
- Run unit tests only: `php artisan test --testsuite=Unit`
- Run feature tests only: `php artisan test --testsuite=Feature`

### Frontend Assets
- Compile assets after modifying Vue/Inertia/Tailwind files: `npm run build`

## Architecture Notes
- Multi-tenant and plugin-ready architecture (`app/`, `plugins/`).
- API uses REST and GraphQL with Laravel Sanctum authentication.
- Always run `./vendor/bin/pint` before completing tasks to adhere to code formatting standards.

### Troubleshooting & Cache
- Clear all caches: `php artisan optimize:clear`
- Tail recent application logs: `tail -n 50 storage/logs/laravel.log`

### End-to-End Testing
- Run Playwright tests: `npm run test:e2e`

## Definition of Done (Task Checklist)
Before completing a task or submitting a PR:
1. Ensure the relevant tests pass: `php artisan test`
2. Check and fix code style: `./vendor/bin/pint`
3. If frontend files (`resources/js/`, `.vue`, css) changed: run `npm run build`
4. If migrations changed: test rolling back and reapplying (`php artisan migrate:rollback` followed by `php artisan migrate`)

