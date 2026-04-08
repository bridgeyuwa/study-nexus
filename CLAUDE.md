# CLAUDE.md – StudyNexus Development Guide

This document provides a comprehensive guide for AI assistants (Claude) working on the StudyNexus codebase. It covers architecture, development workflows, conventions, and common tasks.

---

## 📋 Project Overview

**StudyNexus** is a Laravel 13-based web application that serves as a comprehensive directory and discovery platform for educational institutions in Nigeria. It provides features for browsing institutions, programs, news, exams, and other educational resources.

### Core Purpose
- Directory of educational institutions (universities, colleges, polytechnics, etc.)
- Program discovery and comparison
- News and announcements
- Exam information and timetables
- Institution rankings and filtering

---

## 🏗️ Repository Structure

```
studynexus/
├── app/                          # Application code
│   ├── Console/                  # CLI commands
│   │   └── Commands/
│   ├── Http/                     # HTTP layer
│   │   ├── Controllers/          # Route handlers (currently fat, to be refactored)
│   │   └── Requests/             # (if any form request validation)
│   ├── Livewire/                 # Livewire components (interactive UI)
│   ├── Mail/                     # Mailable classes
│   ├── Models/                   # Eloquent models (27 models total)
│   └── Providers/                # Service providers
├── bootstrap/                    # Laravel bootstrap files
├── config/                       # Configuration files
├── database/
│   ├── factories/                # Model factories for testing
│   ├── migrations/               # Database schema migrations
│   └── seeders/                  # Database seeders
├── docker/                       # Docker configuration
├── docs/                         # Project documentation
│   └── architecture-review.md    # Detailed architecture analysis
├── lang/                         # Language files (i18n)
├── public/                       # Public web root
├── resources/
│   ├── css/                      # Stylesheets
│   ├── js/                       # JavaScript assets
│   ├── markdown/                 # Markdown content
│   ├── views/                    # Blade templates
│   └── lang/                     # Language translations
├── routes/
│   ├── web.php                   # Web routes (primary)
│   ├── console.php               # Console/Artisan commands
│   └── breadcrumbs.php           # Breadcrumb navigation
├── storage/                      # File storage, cache, logs
├── tests/
│   ├── Feature/                  # Feature/integration tests (using Pest)
│   └── Unit/                     # Unit tests (using Pest)
├── .env.example                  # Environment template
├── docker-compose.yaml           # Docker Compose setup
├── composer.json                 # PHP dependencies
├── phpunit.xml                   # PHPUnit/Pest configuration
├── vite.config.js                # Vite bundler configuration
└── CLAUDE.md                     # This file
```

---

## 🔧 Technology Stack

### Backend
- **Framework**: Laravel 13.x
- **Language**: PHP 8.3+
- **Database**: MySQL
- **ORM**: Eloquent (with 27 models)

### Frontend
- **Templating**: Blade
- **Interactive Components**: Livewire
- **Assets**: Vite (Laravel Vite Plugin)
- **Styling**: CSS/SCSS

### Key Packages
- **Cache & SEO**: Laravel built-ins + Spatie packages
  - `spatie/laravel-analytics`
  - `spatie/laravel-backup`
  - `spatie/laravel-newsletter`
  - `spatie/laravel-sitemap`
  - `spatie/schema-org`
- **Image Processing**: `intervention/image-laravel`
- **Geocoding**: `spatie/geocoder`
- **Cloud Storage**: AWS S3 (`league/flysystem-aws-s3-v3`)
- **Breadcrumbs**: `diglactic/laravel-breadcrumbs`
- **Social Sharing**: `jorenvanhocht/laravel-share`
- **Monitoring**: `sentry/sentry-laravel`
- **Self-healing URLs**: `lukeraymonddowning/self-healing-urls`

### Testing & Development
- **Test Framework**: Pest PHP 4.x
- **Mocking**: Mockery
- **Factories**: Faker
- **Code Quality**: Laravel Pint
- **Debugging**: Laravel Debugbar

---

## 📁 Key Directories Explained

### `app/Models`
Contains 27 Eloquent models representing domain concepts:

**Core Entities**:
- `Institution` – Educational institutions with relationships to programs, types, regions
- `Program` – Academic programs offered
- `InstitutionType` – Classification (university, college, polytechnic, etc.)
- `InstitutionProgram` – Junction between institutions and programs

**Hierarchical Data**:
- `Region`, `State`, `Catchment` – Geographic organization
- `Category`, `CategoryClass` – Program categorization
- `Level` – Academic levels (100, 200, 300, 400, etc.)

**Administrative Data**:
- `Exam`, `ExamBody` – Examination information
- `Syllabus`, `Timetable` – Academic scheduling
- `News`, `NewsCategory` – Institution news and updates
- `User` – User accounts

**Reference Data**:
- `AccreditationBody`, `AccreditationStatus` – Accreditation tracking
- `ReligiousAffiliation`, `ReligiousAffiliationCategory` – Affiliation types
- `ProgramMode`, `Term` – Enrollment modes and academic terms
- `Social`, `SocialType` – Social media links
- `InstitutionHead`, `PhoneNumber` – Contact information
- `College` – College/faculty structure

**Current State**: Models are primarily relational wrappers with minimal domain behavior. Data logic is concentrated in controllers (see Architecture Notes).

### `app/Http/Controllers`
Contains 11 controllers handling HTTP requests:

| Controller | Responsibility | Status |
|---|---|---|
| `InstitutionController` | Institution browsing, listing, detail views, ranking | **Refactored** – injects `BuildShareLinksAction`, `ComputeRankingsAction`; `getCategoryClasses()` helper |
| `SearchController` | Institution search with filters | **Refactored** – delegates to `InstitutionSearchQuery` with `SearchFiltersData` DTO |
| `NewsController` | News browsing and display | **Refactored** – injects `GetSimilarNewsAction`, `ComputeReadTimeAction` |
| `ProgramController` | Program details and filtering | **Refactored** – injects `BuildShareLinksAction`, `GetProgramsAtLevelAction` |
| `SitemapController` | XML sitemap generation | **Fat** – complex generation logic (Phase 2 target) |
| `HomeController` | Landing page | Slim |
| `CatchmentController` | Catchment area browsing | Slim |
| `StaticPageController` | Static page rendering | Slim |
| `SyllabusController` | Syllabus display | Slim |
| `TimetableController` | Timetable display | Slim |

**Current State**: Four primary controllers refactored to thin; inject Actions/Queries and delegate. `SitemapController` remains a Phase 2 target.

### `app/Livewire`
Contains interactive Livewire components:
- `ContactForm` – Contact form with email sending
- Other interactive UI elements

**Current State**: Components mix validation, mail orchestration, and error handling inline. Candidates for extraction of reusable actions.

### `routes/web.php`
Defines all web routes. Route groups organize by resource (institutions, programs, news, etc.). Breadcrumbs defined in `routes/breadcrumbs.php`.

### `resources/views`
Blade templates organized by resource type:
- `institutions/` – Institution browsing templates
- `programs/` – Program templates
- `news/` – News templates
- `partials/` – Reusable view partials
- Static and admin pages

### `database/factories`
Test factories for all models. Used by Pest test suite to generate test data quickly.

### `tests`
Organized into Feature and Unit directories:
- **Feature tests**: Test full HTTP flows (controllers, Livewire, integration)
- **Unit tests**: Test isolated functions/classes

**Current State**: Comprehensive test suite added recently; migrated to Pest syntax.

---

## 🗂️ Architecture Overview & Roadmap

### Current Architecture Score: 42/100 *(was 21/100 before Phase 1)*

The codebase has completed **Phase 1 Beyond CRUD refactoring**: all four fat controllers have been thinned, duplicate logic is extracted into dedicated Actions, Queries, and DTOs, and a 50-test Pest suite covers the new layer.

**Remaining Issues** (in priority order):
1. **Anemic Models** – Models are still relational wrappers; domain logic is in actions/controllers.
2. **No Query Objects for Ranking** – `InstitutionRankingQuery` not yet extracted (ranking still complex in `ComputeRankingsAction`).
3. **SitemapController fat** – Sitemap generation not yet extracted into an action.
4. **Hidden Dependencies** – View composers in `AppServiceProvider` still pull `CategoryClass::all()` globally.
5. **Livewire components mixed** – `ContactForm` mixes validation, mail, and error handling inline.

### Refactoring Roadmap

#### Phase 1: Quick Wins (Extract Duplicate Logic) ✅ **COMPLETE**
- [x] Create `app/Actions` directory and extract reusable actions:
  - [x] `BuildShareLinksAction` – Replaces 12× duplicated share-link setup across all controllers
  - [x] `GetSimilarNewsAction` – Replaces 3× identical similar-news query in `NewsController`
  - [x] `ComputeReadTimeAction` – Extracts inline read-time calculation
  - [x] `ComputeRankingsAction` – Extracts 47-line ranking algorithm from `InstitutionController`
  - [x] `GetProgramsAtLevelAction` – Extracts level-3/normal program grouping logic
- [x] Create `app/Queries` directory:
  - [x] `InstitutionSearchQuery` – All 6 filter branches + eager loading + sorting extracted from `SearchController`
- [x] Create `app/DTOs` directory:
  - [x] `SearchFiltersData` – Typed readonly DTO with `cacheKey()` for search filters
- [x] Replace duplicated code in `NewsController`, `ProgramController`, `InstitutionController`, `SearchController`
- [x] Add focused feature tests around extracted actions (50 tests / 75 assertions)
- [ ] `BuildSeoDataAction` – SEO metadata still set up inline per controller
- [ ] `GenerateSitemapAction` – Sitemap generation still in `SitemapController`

#### Phase 2: Intermediate Refactoring (Services & Query Objects)
- [ ] Create `app/Application` and `app/Domain` folder structure by context
- [ ] Introduce remaining query objects:
  - [ ] `InstitutionRankingQuery` – Ranking page queries (currently in `ComputeRankingsAction`)
  - [x] `InstitutionSearchQuery` – **Done in Phase 1**
  - [x] `GetSimilarNewsAction` (action) – **Done in Phase 1**
- [ ] Create `app/Repositories` or use query objects to encapsulate complex data access
- [ ] Introduce DTOs using `spatie/laravel-data` for search filters and result payloads (currently plain PHP DTOs)

#### Phase 3: Full DDD Transformation (Bounded Contexts)
- [ ] Restructure by bounded context:
  ```
  app/Domain/<Context>/
    - Entities/
    - ValueObjects/
    - Events/
  app/Application/<Context>/
    - Actions/
    - Queries/
  app/Infrastructure/<Context>/
    - Repositories/
  app/UI/Http/
    - Controllers/
    - Resources/
  ```
- [ ] Introduce domain events for side-effects (e.g., sitemap refresh on news update)
- [ ] Create value objects (immutable, typed data holders)
- [ ] Expand test coverage at action/domain layer

### Architecture Principles

When working on this codebase, follow these principles:

1. **Controllers should be thin** – Route to action, pass data, return response. No query building, caching, or orchestration logic.
2. **Use Action Classes** – Single-responsibility actions that encapsulate use-cases. Return DTOs or domain objects.
3. **Query Objects** – Complex queries should live in dedicated query classes, not controllers.
4. **DTOs for Data Transfer** – Use typed data objects (Spatie Data or custom classes) for request/response payloads.
5. **Models as Entities** – Keep Eloquent models focused on relationships and basic domain behavior. Push orchestration to actions.
6. **Test at the Action Layer** – Write tests for actions and queries, not controllers.
7. **Explicit Dependencies** – Inject dependencies into actions/services. Avoid global facades in domain logic.

### Example Refactoring Pattern

**Before** (Fat Controller):
```php
// SearchController@index
public function index(Request $request)
{
    $query = Institution::query();
    if ($typeSlug) {
        $query->whereHas('institutionType', fn($q) => $q->where('slug', $typeSlug));
    }
    // ... 20+ lines of filter building
    return $query->paginate(30)->appends($request->except('page'));
}
```

**After** (Action + Query Object + DTO):
```php
// Routes/web.php
Route::get('/search', SearchInstitutionsAction::class);

// app/Actions/SearchInstitutionsAction.php
final class SearchInstitutionsAction
{
    public function __invoke(SearchInstitutionsRequest $request)
    {
        $results = $this->query->execute(
            SearchInstitutionsData::from($request->validated())
        );
        return response()->view('institutions.search', ['results' => $results]);
    }
}

// app/Queries/InstitutionSearchQuery.php
final class InstitutionSearchQuery
{
    public function execute(SearchInstitutionsData $filters): LengthAwarePaginator
    {
        return Institution::query()
            ->when($filters->typeSlug, fn($q) => $q->whereHas('institutionType', ...))
            // ... filtering logic
            ->paginate(30);
    }
}
```

---

## 🧪 Testing Strategy

### Testing Framework: Pest PHP

Tests are organized into **Feature** (integration) and **Unit** (isolated) test suites.

### Running Tests

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test
php artisan test tests/Feature/SearchInstitutionsTest.php

# Watch mode (re-runs on file change)
php artisan test --watch
```

### Test Structure

```
tests/
├── Feature/
│   ├── InstitutionBrowsingTest.php      # Test institution listing and detail
│   ├── SearchInstitutionsTest.php       # Test search functionality
│   ├── NewsViewingTest.php              # Test news display
│   └── ...
├── Unit/
│   ├── Models/InstitutionTest.php       # Test model relationships
│   ├── Actions/SearchInstitutionsActionTest.php
│   └── ...
├── Pest.php                             # Pest configuration and helpers
└── TestCase.php                         # Base test class
```

### Database Seeding for Tests

Models have factories in `database/factories/`. Use them to generate test data:

```php
use App\Models\Institution;
use Database\Factories\InstitutionFactory;

test('can search institutions', function () {
    Institution::factory()->count(5)->create();
    
    $response = $this->get('/search?type=university');
    $response->assertStatus(200);
});
```

### Key Testing Patterns

- **Feature tests** test full HTTP flows (request → controller → response)
- **Unit tests** test isolated classes (actions, queries, models)
- **Database tests** use `RefreshDatabase` trait to rollback between tests
- **Factories** generate realistic test data

**Guidelines for AI Assistants**:
- Write tests when adding features or fixing bugs
- Test at the appropriate level (Feature for controllers, Unit for actions/queries)
- Use factories to generate test data quickly
- Keep tests focused and readable

---

## 🎯 Code Conventions

### PHP & Laravel Conventions

1. **Naming**:
   - Classes: `PascalCase` (e.g., `InstitutionController`, `GetSimilarNewsAction`)
   - Methods: `camelCase` (e.g., `searchInstitutions`, `getSimilarNews`)
   - Variables: `camelCase` (e.g., `$institutions`, `$newsCategories`)
   - Constants: `UPPER_SNAKE_CASE` (e.g., `CACHE_EXPIRY`)
   - Database tables: `snake_case` plural (e.g., `institutions`, `program_modes`)
   - Model properties: `camelCase` with `protected $fillable`

2. **Type Hints**:
   - Use full type hints for parameters and return types
   - Use nullable types where appropriate (`?Model`)
   - Use union types for multiple possible types (`Model|Collection`)

3. **Comments**:
   - Write comments only for **why**, not **what** (code should be self-documenting)
   - Use PHPDoc blocks for complex methods
   - Avoid obvious comments

4. **Models**:
   - Use `protected $fillable` to whitelist mass-assignable attributes
   - Define relationships clearly with type hints
   - Keep domain logic minimal (push to actions)
   - Use `final class` to prevent unintended inheritance

5. **Controllers**:
   - Keep controllers **thin** – route to action, pass data, return response
   - Inject dependencies (services, actions) via constructor
   - Return views or JSON responses, not raw data
   - Use type-hinted parameters for validation (Request objects)

6. **Actions**:
   - Single responsibility: one action = one use-case
   - Use `__invoke()` or `execute()` method as entry point
   - Return domain objects, DTOs, or collections
   - Inject dependencies via constructor
   - Use `final class` to encourage composition over inheritance

7. **Queries/Repositories**:
   - Encapsulate complex query logic
   - Return `Collection`, `Model`, `LengthAwarePaginator`, or similar
   - Use method names that describe what they do (`findBySlug()`, `searchByFilters()`)

8. **Blade Templates**:
   - Use `@forelse` for safe iteration
   - Prefix custom components with namespace if needed
   - Keep business logic out of views; use view composers or pass data from controller

### File Organization

- **One class per file** (PSR-4 standard)
- Use namespaces matching directory structure
- Group related methods together (public, protected, private)

---

## 🚀 Development Workflows

### Setting Up the Project

```bash
# Clone repository
git clone https://github.com/bridgeyuwa/studynexus.git
cd studynexus

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed  # if seeders exist

# Run development server
php artisan serve
npm run dev  # in another terminal for Vite

# Visit http://localhost:8000
```

### Using Docker (Recommended)

```bash
# Start containers
docker-compose up -d

# Install dependencies in container
docker-compose exec app composer install
docker-compose exec app npm install

# Database migration
docker-compose exec app php artisan migrate

# View logs
docker-compose logs -f app
```

### Making Changes

1. **Create a feature branch**:
   ```bash
   git checkout -b claude/feature-name-SHORT_ID
   ```

2. **Make changes** following conventions above

3. **Run tests**:
   ```bash
   php artisan test
   ```

4. **Lint and format** (using Pint):
   ```bash
   ./vendor/bin/pint
   ```

5. **Commit changes**:
   ```bash
   git add .
   git commit -m "Add feature X"
   ```

6. **Push to branch**:
   ```bash
   git push origin claude/feature-name-SHORT_ID
   ```

### Common Development Tasks

#### Adding a New Feature

1. **Create a model** (if needed):
   ```bash
   php artisan make:model ModelName -mf
   # -m: create migration, -f: create factory
   ```

2. **Create a migration**:
   ```bash
   php artisan make:migration create_table_name
   ```

3. **Create an action**:
   ```bash
   mkdir -p app/Actions
   # Create class in app/Actions/YourAction.php
   ```

4. **Create a route** in `routes/web.php`

5. **Create tests** in `tests/Feature/` or `tests/Unit/`

6. **Create views** in `resources/views/` (if needed)

#### Modifying a Model

1. **Update model class** in `app/Models/`
2. **Create migration** for schema changes:
   ```bash
   php artisan make:migration add_field_to_table
   ```
3. **Update factory** in `database/factories/` if test data structure changes
4. **Write/update tests** for model behavior

#### Extracting Duplicated Logic

1. **Identify duplicate code** (usually in controllers or Livewire components)
2. **Create an Action** in `app/Actions/`
3. **Test the action** with `ActionTest.php`
4. **Replace duplicates** by calling the action
5. **Delete original code** once replacements are verified

#### Running Migrations

```bash
# Run all pending migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Rollback all and re-run
php artisan migrate:refresh

# With seeding
php artisan migrate:refresh --seed
```

---

## 🌳 Git Workflow

### Branch Naming Convention

Use feature branch naming for Claude-generated branches:
```
claude/<feature-name>-<SHORT_ID>
```

Example:
- `claude/add-claude-documentation-A6Ero`
- `claude/extract-search-action-K9xL2`
- `claude/fix-ranking-algorithm-M2pQr`

### Commit Messages

Write clear, descriptive commit messages:

```bash
# Format: <type>: <description>

git commit -m "feat: extract search institution action"
git commit -m "fix: correct ranking algorithm edge case"
git commit -m "test: add search institution action tests"
git commit -m "refactor: move sitemap logic to action"
```

**Types**:
- `feat:` – New feature
- `fix:` – Bug fix
- `refactor:` – Code reorganization without behavior change
- `test:` – Test additions or modifications
- `docs:` – Documentation updates
- `chore:` – Maintenance (dependencies, config, etc.)

### Pull Request Workflow

1. **Push your branch** to origin:
   ```bash
   git push -u origin claude/feature-name-SHORT_ID
   ```

2. **Create PR** on GitHub (usually auto-prompted)

3. **PR Description** should include:
   - What changed (summary)
   - Why it changed (motivation)
   - How to test it
   - Any breaking changes

4. **Wait for review** and address feedback

5. **Merge** when approved

### Current Development Branch

**Primary development branch**: `claude/add-claude-documentation-A6Ero`

This branch is where Claude-generated documentation and initial refactoring work is being done.

---

## 📊 Models & Relationships (Quick Reference)

### Entity Relationship Diagram (Simplified)

```
Institution
  ├── has many → Programs (through InstitutionProgram)
  ├── belongs to → InstitutionType
  ├── belongs to → State
  ├── has many → Accreditations
  ├── has many → News
  └── has many → InstitutionHeads

Program
  ├── has many → Institutions (through InstitutionProgram)
  ├── belongs to → Level
  ├── belongs to → Category
  ├── belongs to → ProgramMode
  └── belongs to → Syllabus

News
  ├── belongs to → Institution
  └── has many → NewsCategories (through junction)
```

### Key Model Methods

Each model has:
- **Relationships** defined as methods (e.g., `institutions()`, `programs()`)
- **Factories** in `database/factories/` for test data generation
- **Fillable attributes** defined in `protected $fillable`

See `app/Models/` directory for full definitions.

---

## 🔍 Debugging & Troubleshooting

### Common Issues

**Issue**: "Column not found" error
- **Cause**: Database migration wasn't run or column name mismatch
- **Solution**: Run `php artisan migrate` and check migration files

**Issue**: Model not found / class not found
- **Cause**: Namespace or file path wrong, or autoloader not updated
- **Solution**: Verify PSR-4 namespace matches directory structure, run `composer dump-autoload`

**Issue**: View not found
- **Cause**: View file path mismatch
- **Solution**: Verify file exists at correct path in `resources/views/`

**Issue**: Route not working
- **Cause**: Route not defined or middleware blocking
- **Solution**: Check `routes/web.php` and run `php artisan route:list`

### Debugging Tools

- **Tinker** (REPL for Laravel):
  ```bash
  php artisan tinker
  # Try queries, test logic without running HTTP request
  ```

- **Debugbar** (in development):
  - Installed as dev dependency
  - Shows at bottom of page (in dev mode)
  - Inspect queries, views, config, etc.

- **Logs**:
  ```bash
  tail -f storage/logs/laravel.log
  ```

- **Email Testing**:
  - Mailpit service in Docker handles test emails
  - View at `http://localhost:8025`

---

## 📚 Useful Commands

```bash
# Artisan commands
php artisan tinker                          # Interactive shell
php artisan route:list                      # List all routes
php artisan cache:clear                     # Clear cache
php artisan config:clear                    # Clear config cache
php artisan view:clear                      # Clear view cache
php artisan storage:link                    # Create storage symlink

# Composer commands
composer update                             # Update dependencies
composer require package/name               # Install package
composer dump-autoload                      # Regenerate autoloader

# Testing
php artisan test                            # Run all tests
php artisan test --coverage                 # With code coverage
php artisan test --watch                    # Watch mode

# Code quality
./vendor/bin/pint                           # Format code with Pint
./vendor/bin/pint --test                    # Check formatting without changing
```

---

## 🚧 Known Issues & Future Work

### Known Limitations

1. **Controllers are large** – Primary refactoring target (see Phase 1 roadmap)
2. **No request validation classes** – Form requests not implemented
3. **Livewire components lack separation** – Validation and mail logic mixed in
4. **Limited test coverage** – Recent improvements, but still incomplete
5. **No API layer** – All endpoints are web (Blade) only

### Planned Improvements

- [ ] Extract actions for all controllers (Phase 1)
- [ ] Add query objects for complex searches/filters (Phase 2)
- [ ] Introduce DTOs with Spatie Data package (Phase 2)
- [ ] Restructure into bounded contexts (Phase 3)
- [ ] Add domain events for side-effects (Phase 3)
- [ ] Expand test coverage to 80%+ (Ongoing)
- [ ] Consider REST API or GraphQL layer (Future)

---

## 📖 Additional Resources

### External Documentation

- [Laravel 13 Documentation](https://laravel.com/docs/13.x)
- [Pest PHP Documentation](https://pestphp.com)
- [Livewire Documentation](https://livewire.laravel.com)
- [Spatie Packages](https://spatie.be/open-source)

### Architecture References

- `docs/architecture-review.md` – Detailed architecture analysis and scoring
- Current branch: `claude/add-claude-documentation-A6Ero` – Documentation and refactoring work

### Contact & Support

- **Repository**: https://github.com/bridgeyuwa/studynexus
- **Issues**: https://github.com/bridgeyuwa/studynexus/issues

---

## 🎓 Key Takeaways for AI Assistants

1. **This is a Laravel CRUD app with architectural weaknesses** – Controllers are fat and need refactoring.
2. **Follow the roadmap** – Phase 1 (extract actions), Phase 2 (query objects/DTOs), Phase 3 (DDD).
3. **Write tests for new code** – Use Pest, test at appropriate levels (Feature vs Unit).
4. **Keep controllers thin** – Route to action, pass data, return response. No business logic.
5. **Use Actions for reusable logic** – Single responsibility, injected dependencies, testable.
6. **Refer to conventions** – Naming, typing, file organization matter for team consistency.
7. **Commit to feature branches** – Use `claude/feature-name-SHORT_ID` pattern.
8. **Document your changes** – Update this file if architecture changes significantly.

---

**Last Updated**: April 8, 2026  
**Status**: Active Development (Laravel 13 – Phase 1 Complete – Phase 2 Roadmap Next)

===

<laravel-boost-guidelines>
=== .ai/core rules ===

# Project Coding Guidelines

- This codebase follows Spatie's Laravel & PHP guidelines.
- Always activate the `spatie-laravel-php-standards` skill whenever writing, editing, reviewing, or formatting Laravel or PHP code.

=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4
- laravel/framework (LARAVEL) - v13
- laravel/prompts (PROMPTS) - v0
- livewire/livewire (LIVEWIRE) - v4
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.
- To check environment variables, read the `.env` file directly.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== tests rules ===

# Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test --compact` with a specific filename or filter.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

## Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== livewire/core rules ===

# Livewire

- Livewire allow to build dynamic, reactive interfaces in PHP without writing JavaScript.
- You can use Alpine.js for client-side interactions instead of JavaScript frameworks.
- Keep state server-side so the UI reflects it. Validate and authorize in actions as you would in HTTP requests.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

</laravel-boost-guidelines>
