# Alladdin CRM

<p align="center">
  <img src="public/brand/aladdin-crm-logo.svg" alt="Alladdin CRM Logo" width="360" />
</p>

<p align="center">
  <a href="https://github.com/aptus0/AladdinCRM/actions/workflows/lint.yml"><img src="https://github.com/aptus0/AladdinCRM/actions/workflows/lint.yml/badge.svg?branch=main" alt="Linter"></a>
  <a href="https://github.com/aptus0/AladdinCRM/actions/workflows/tests.yml"><img src="https://github.com/aptus0/AladdinCRM/actions/workflows/tests.yml/badge.svg?branch=main" alt="Tests"></a>
  <a href="https://github.com/aptus0/AladdinCRM/actions/workflows/release.yml"><img src="https://github.com/aptus0/AladdinCRM/actions/workflows/release.yml/badge.svg" alt="Release"></a>
  <a href="https://github.com/aptus0/AladdinCRM/releases"><img src="https://img.shields.io/github/v/release/aptus0/AladdinCRM?sort=semver" alt="Latest Release"></a>
  <a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="License"></a>
  <a href="https://github.com/aptus0/AladdinCRM/issues"><img src="https://img.shields.io/github/issues/aptus0/AladdinCRM" alt="Issues"></a>
  <a href="https://github.com/aptus0/AladdinCRM/pulls"><img src="https://img.shields.io/github/issues-pr/aptus0/AladdinCRM" alt="Pull Requests"></a>
  <a href="https://github.com/aptus0/AladdinCRM/stargazers"><img src="https://img.shields.io/github/stars/aptus0/AladdinCRM" alt="Stars"></a>
  <a href="https://github.com/aptus0/AladdinCRM/network/members"><img src="https://img.shields.io/github/forks/aptus0/AladdinCRM" alt="Forks"></a>
  <a href="https://github.com/aptus0/AladdinCRM/graphs/contributors"><img src="https://img.shields.io/github/contributors/aptus0/AladdinCRM" alt="Contributors"></a>
  <a href="https://github.com/aptus0/AladdinCRM/commits/main"><img src="https://img.shields.io/github/last-commit/aptus0/AladdinCRM/main" alt="Last Commit"></a>
  <a href="https://github.com/aptus0/AladdinCRM/labels/good%20first%20issue"><img src="https://img.shields.io/github/issues/aptus0/AladdinCRM/good%20first%20issue" alt="Good First Issues"></a>
  <a href="CONTRIBUTING.md"><img src="https://img.shields.io/badge/contributions-welcome-orange.svg" alt="Contributions Welcome"></a>
  <a href="https://img.shields.io/badge/PRs-welcome-brightgreen.svg"><img src="https://img.shields.io/badge/PRs-welcome-brightgreen.svg" alt="PRs Welcome"></a>
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777bb4.svg" alt="PHP">
  <img src="https://img.shields.io/badge/Laravel-12-ff2d20.svg" alt="Laravel">
  <img src="https://img.shields.io/badge/Svelte-5-ff3e00.svg" alt="Svelte">
  <img src="https://img.shields.io/badge/Inertia-2-9553e9.svg" alt="Inertia">
</p>

Alladdin CRM is a modern full-stack CRM for small teams to manage sales + support operations in one panel:

- Company + Contact management
- Opportunity pipeline
- Quote + PDF export
- Task board (Kanban)
- Ticket + message flow
- Activity log + dashboard metrics

## Live Demo

- Public URL: https://dxx92tlfac.sharedwithexpose.com
- Note: This is an Expose Free tunnel created on February 21, 2026 and may expire.
- Re-open tunnel command:

```bash
expose share aladdincrm.test --server=free
```

## Product Scope (MVP)

- Auth: login/logout, email verification, role support (`admin`, `staff`)
- CRM Core: companies + contacts (search/filter/pagination/soft-delete)
- Sales: opportunities with stage tracking + pipeline summary
- Quotes: quote items, automatic totals, PDF export
- Tasks: Kanban with drag-drop order/status updates
- Support: tickets and threaded ticket messages
- Audit: activity log for key state changes
- Dashboard: due tasks, open tickets, pipeline total, recent activity

Full blueprint: [`docs/alladdin-crm-mvp.md`](docs/alladdin-crm-mvp.md)

## Tech Stack

- Backend: Laravel 12, PHP 8.2+, Fortify auth, Wayfinder
- Frontend: Svelte 5 + Inertia.js 2 + Tailwind CSS 4
- Database: SQLite / MySQL / PostgreSQL
- PDF: quote export endpoint + Blade PDF template
- Tooling: Vite, ESLint, Prettier, Pest/PHPUnit, Pint

## Screenshots

### Dashboard

![Dashboard](public/images/landing/dashboard-overview.svg)

### Quotes + PDF

![Quotes PDF](public/images/landing/quotes-pdf.svg)

### Task Kanban

![Tasks Kanban](public/images/landing/tasks-kanban.svg)

### Tickets

![Tickets](public/images/landing/tickets-support.svg)

## Quick Start

### 1) Install dependencies

```bash
composer install
npm install
```

### 2) Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

### 3) Database

For SQLite:

```bash
touch database/database.sqlite
```

Then run migrations + seeders:

```bash
php artisan migrate:fresh --seed
```

### 4) Run application

```bash
composer run dev
```

Alternative split terminal mode:

```bash
php artisan serve
php artisan queue:listen --tries=1 --timeout=0
npm run dev
```

## Demo Accounts (Seeded)

All seeded users use the same password: `password`

- `admin@aladdincrm.test` (Admin)
- `sales@aladdincrm.test` (Staff)
- `staff@aladdincrm.test` (Staff)
- `support@aladdincrm.test` (Staff)
- `ops@aladdincrm.test` (Staff)

Seeder entrypoint: [`database/seeders/DatabaseSeeder.php`](database/seeders/DatabaseSeeder.php)

## API Overview

All API routes are under `/api` and protected by `auth + verified + license middleware`.

- `GET /api/dashboard/metrics`
- `GET /api/system/status`
- `GET /api/opportunities/pipeline-summary`
- `POST /api/tasks/{task}/move`
- `POST /api/tickets/{ticket}/messages`
- `GET /api/quotes/{quote}/pdf`
- CRUD resources:
  - `/api/companies`
  - `/api/contacts`
  - `/api/opportunities`
  - `/api/quotes`
  - `/api/tasks`
  - `/api/tickets`

Route source: [`routes/web.php`](routes/web.php)
System status API docs: [`docs/system-status-api.md`](docs/system-status-api.md)

## Project Structure

```text
app/
  Actions/
  Data/
  Http/
  Policies/
  Services/
resources/
  js/
    components/
    layouts/
    pages/
database/
  migrations/
  seeders/
docs/
```

## Quality Commands

```bash
npm run check
npm run build
composer test
```

## Versioning + Release

- Semantic Versioning: `MAJOR.MINOR.PATCH`
- Set version via `.env`:

```env
APP_VERSION=1.0.0
```

Release example:

```bash
git tag v1.0.0
git push origin v1.0.0
```

GitHub Actions release workflow is available at:
[`/.github/workflows/release.yml`](.github/workflows/release.yml)

## Optional License + Integrity Controls

License/version check env options:

```env
ALLADDIN_LICENSE_KEY=
LICENSE_CHECK_ENABLED=false
LICENSE_ENFORCE=false
LICENSE_VERIFY_URL=
LICENSE_CACHE_MINUTES=10
LICENSE_TIMEOUT_SECONDS=3
APP_VERSION_CHECK_URL=
APP_VERSION_CACHE_MINUTES=30
APP_VERSION_TIMEOUT_SECONDS=3
```

Integrity snapshot/check:

```bash
php artisan app:integrity:snapshot
php artisan app:integrity:check
```

Details: [`docs/open-source-model.md`](docs/open-source-model.md)

## Contributing

- Use conventional commits (`feat:`, `fix:`, `refactor:`, `docs:`, `test:`, `chore:`)
- Keep controllers thin, business logic in service/action layer
- Add tests for behavior changes
- Read the full guide: [`CONTRIBUTING.md`](CONTRIBUTING.md)
- Open issue templates: [Bug](.github/ISSUE_TEMPLATE/bug-report.yml), [Feature](.github/ISSUE_TEMPLATE/feature-request.yml), [Task](.github/ISSUE_TEMPLATE/task.yml), [Docs](.github/ISSUE_TEMPLATE/documentation.yml)
- Ready issue pool for maintainers: [`docs/issue-backlog.md`](docs/issue-backlog.md)

## License

Released under the MIT License. See [`LICENSE`](LICENSE).
