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

## Documentation Reference
The `docs/` folder contains comprehensive documentation about the application's architecture, features, APIs, and roadmap. Always consult these resources when working on related tasks.

### Core Architecture & APIs
- **Plugin Development (`docs/PLUGIN_DEVELOPMENT.md`)**: The primary guide for building, testing, and publishing WordPress-style plugins for Inventoros. **Always review this before starting any plugin-related tasks.**
- **REST & GraphQL API (`docs/api/`)**: Read `docs/api/README.md` for details on authentication, rate limits, and an overview of the REST endpoints and GraphQL support. The `docs/api/openapi.yaml` file contains the full OpenAPI 3.0 specification.
- **MCP Server (`docs/mcp/README.md`)**: Documentation on the built-in Model Context Protocol server.

### Application Features
- **Features (`docs/features/`)**: Contains detailed guides on core application functionality, such as barcode scanning, email notifications, import/export, and warehouses.

### Roadmap & Archives
- **Roadmap (`docs/archive/ROADMAP.md`)**: The current development roadmap, containing a checklist of planned features grouped by phase.
  - *Note: Check this file for planned features, but be aware that it's in the `archive/` folder, so some completed features might not be checked off, or priorities might have shifted. When you encounter incomplete tasks, consider whether they should be implemented or if you should instruct future agents to review them.*
- **Audits & Progress (`docs/archive/`)**: Look here for historical context on audits and implemented features (e.g., `IMPLEMENTATION_SUMMARY.md`, `AUDIT_REPORT.md`).

### End-User Guides
- **Site Documentation (`docs/site/`)**: Contains the JSON structure (`docs.json`) and markdown content for the public-facing documentation site, covering installation, updates, and feature usage.
