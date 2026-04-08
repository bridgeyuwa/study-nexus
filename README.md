# StudyNexus

A Laravel 13 web application serving as a comprehensive directory and discovery platform for educational institutions in Nigeria.

## Features

- Browse universities, colleges, polytechnics, and other institution types
- Filter and search institutions by name, location, program, and category
- Program discovery — find which institutions offer a given course
- Institution rankings by national, state, and regional scope
- News and announcements per institution
- Exam information and timetables
- Catchment area policies

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 13.x (PHP 8.3+) |
| Frontend | Blade + Livewire v4 + Vite |
| Database | MySQL |
| Testing | Pest PHP 4.x / PHPUnit 12 |
| Self-healing URLs | `lukeraymonddowning/self-healing-urls` |
| SEO | `ralphjsmit/laravel-seo` + `spatie/schema-org` |
| Sitemap | `spatie/laravel-sitemap` |
| Analytics | `spatie/laravel-analytics` |
| Backups | `spatie/laravel-backup` |
| Monitoring | `sentry/sentry-laravel` |
| AI Assistance | Laravel Boost v2 |

## Getting Started

### Local Development

```bash
git clone https://github.com/bridgeyuwa/studynexus.git
cd studynexus
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
npm run dev   # in a second terminal
```

### Docker (Recommended)

```bash
docker-compose up -d
docker-compose exec app composer install
docker-compose exec app npm install
docker-compose exec app php artisan migrate
# App: http://localhost:8000  |  Mail: http://localhost:8025
```

## Testing

```bash
php artisan test --compact          # run all tests
php artisan test --compact --filter=InstitutionControllerTest
./vendor/bin/pint --dirty           # format changed PHP files
```

## Documentation

| File | Purpose |
|---|---|
| `CLAUDE.md` | Developer & AI assistant guide (architecture, conventions, workflows) |
| `docs/architecture-review.md` | Architecture analysis, scoring, and refactoring roadmap |
| `docs/laravel-13-upgrade-guide.md` | Laravel 13 upgrade record (completed April 2026) |

## Repository

- **GitHub**: https://github.com/bridgeyuwa/studynexus
- **Issues**: https://github.com/bridgeyuwa/studynexus/issues
