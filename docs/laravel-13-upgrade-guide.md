# Laravel 13 Upgrade Guide

**Status**: Laravel 13 is not yet available in the Composer ecosystem as of April 2026.  
**Current Version**: Laravel 12.56.0  
**Last Updated**: April 8, 2026

## Overview

This guide documents the upgrade path to Laravel 13 once it becomes available. The StudyNexus application is currently on Laravel 12 and has been assessed for breaking changes that will need to be addressed.

## Ecosystem Availability Status

### Not Yet Available
- Laravel 13 framework (as of April 2026)
- Third-party package updates for Laravel 13 compatibility

### Versions Requiring Updates (when L13 is released)
- `levintoo/self-healing-urls`: Currently v1.0 (supports ^10|^11|^12), needs v2.0 for ^13
- `pestphp/pest-plugin-laravel`: Currently v3.2 (supports ^11|^12), needs v4+ for ^13
- Other Spatie packages have already added compatibility

## Assessment Findings

### Current Application State

#### No Action Required - Not Found
✓ **CSRF Middleware**: No custom `VerifyCsrfToken` class found
- Bootstrap uses modern `validateCsrfTokens()` method
- Already compatible with Laravel 13 approach

✓ **Queue Jobs**: No queue jobs found in `app/Console` or `app/Jobs`
- No event property renames needed
- Database queue driver configured

✓ **Cache Serialization**: Uses database driver with no serialization config
- No class allow-list configuration needed
- Already compatible

#### Review Needed - But Low Risk

1. **Pagination (57 occurrences)**
   - Uses standard `.links()` method throughout
   - Files affected:
     - `/resources/views/search.blade.php`
     - `/resources/views/institution/ranking.blade.php`
     - `/resources/views/institution/index.blade.php`
     - `/resources/views/program/institutions.blade.php`
     - `/resources/views/news/index.blade.php`
     - Plus 7 other views
   - **Status**: No changes expected; Laravel 13 maintains backward compatibility with Tailwind pagination views

2. **Container Nullable Classes**
   - Check: `/bootstrap/app.php` for container bindings
   - **Status**: No custom bindings that would be affected

## Upgrade Steps (When Laravel 13 Released)

### Phase 1: Dependency Updates

```bash
# 1. Update composer.json
composer require laravel/framework:^13.0 --no-update

# 2. Update ecosystem packages
composer require levintoo/self-healing-urls:^2.0 --no-update
# Note: pestphp/pest-plugin-laravel v4+ will likely be required

# 3. Resolve dependencies
composer update -W

# 4. Verify installation
php artisan --version
```

### Phase 2: Code Updates

#### 1. CSRF Middleware (If Custom Class Exists)
**Breaking Change**: `Illuminate\Foundation\Http\Middleware\VerifyCsrfToken` renamed to `PreventRequestForgery`

**Affected Files**: None found in StudyNexus  
**Action**: Skip (using modern bootstrap method)

#### 2. Cache Serialization (If Using Redis/Memcached)
**Breaking Change**: Cache drivers now require explicit class allow-lists for serialized data

**Current Setup**: Database cache driver (no change needed)  
**If Using Redis/Memcached in Future**:
```php
// config/cache.php
'redis' => [
    'driver' => 'redis',
    'connection' => 'cache',
    'serialize' => [
        'classes' => [
            // Add your domain classes here
            'App\Models\Institution',
            'App\Models\Program',
        ],
    ],
],
```

#### 3. Queue Events (If Using Queues)
**Breaking Change**: Queue event property renames
- `Illuminate\Queue\Events\JobQueued` → Check property names
- `Illuminate\Queue\Events\JobFailed` → Check property names

**Current Setup**: No queue jobs found  
**Action**: Skip for now; review if queue jobs added

#### 4. Pagination Views
**Potential Change**: View names may change  
**Current Setup**: Uses `.links()` with default Tailwind views  
**Action**: Test after upgrade; likely no changes needed

### Phase 3: Testing

```bash
# 1. Run full test suite
php artisan test

# 2. Lint code
./vendor/bin/pint

# 3. Check for deprecation warnings
php artisan tinker
# Try querying models, caching, etc.

# 4. Manual UI testing
npm run build
npm run dev
# Test pagination, forms, etc.
```

## Detailed Breaking Changes Reference

### 1. CSRF Middleware

**Current** (Laravel 12 compatible):
```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->validateCsrfTokens(except: ['livewire/update']);
})
```

**Future** (Laravel 13):
- No changes needed; bootstrap method is forward-compatible
- If custom middleware class was used, class rename would be required:
  ```php
  // OLD
  use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
  // NEW
  use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
  ```

### 2. Cache Serialization

**Current** (Laravel 12):
```php
// config/cache.php - No serialization config needed
'redis' => [
    'driver' => 'redis',
    'connection' => 'cache',
],
```

**Future** (Laravel 13):
- Must define allowed classes for serialized data
- Only needed if storing complex objects in cache
- StudyNexus primarily caches scalars and arrays

### 3. Queue Events

**Affected Classes** (if queue jobs exist):
- `Illuminate\Queue\Events\JobQueued`
- `Illuminate\Queue\Events\JobFailed`
- `Illuminate\Queue\Events\JobProcessed`
- `Illuminate\Queue\Events\JobExceptionOccurred`

**Current State**: Not used in StudyNexus

### 4. Pagination View Names

**Current** (Laravel 12):
```blade
{{ $paginator->links() }}  {{-- Uses views/vendor/pagination/tailwind.blade.php --}}
{{ $paginator->links('pagination::bootstrap-4') }}  {{-- Explicit view name --}}
```

**Laravel 13 Change**: View names may be reorganized  
**Action**: After upgrade, verify pagination renders correctly

### 5. Container Nullable Classes

**Breaking Change**: Container's `make()` and `resolve()` behavior with nullable classes

**Example Issue** (unlikely in StudyNexus):
```php
// If binding optional services
$container->bind('optional-service', null);  // May behave differently
```

**Current State**: No custom container bindings found

## Dependency Version Matrix

| Package | Laravel 12 | Laravel 13 |
|---------|-----------|-----------|
| laravel/framework | ^12.0 | ^13.0 |
| levintoo/self-healing-urls | ^1.0 | ^2.0 |
| pestphp/pest-plugin-laravel | ^3.2 | ^4.0+ (expected) |
| spatie/laravel-analytics | ^5.7 | ^5.7+ |
| spatie/laravel-sitemap | ^7.2 | ^7.2+ |
| spatie/laravel-backup | ^9.0 | ^9.0+ |
| diglactic/laravel-breadcrumbs | ^10.0 | ^10.0+ |
| livewire/livewire | * | * |

## Pre-Upgrade Checklist

- [ ] Laravel 13 released and available on Packagist
- [ ] All third-party packages updated to support Laravel 13
- [ ] Create feature branch: `claude/upgrade-laravel-13-XX`
- [ ] Update `composer.json`
- [ ] Run `composer update -W`
- [ ] Run full test suite
- [ ] Run Pint code formatter
- [ ] Test UI pagination manually
- [ ] Test forms and CSRF validation
- [ ] Test caching (if using Redis)
- [ ] Test queues (if queue jobs exist)
- [ ] Create PR for review

## Resources

- [Laravel 9+ Upgrade Guide](https://laravel.com/docs/upgrade)
- [Laravel GitHub Releases](https://github.com/laravel/framework/releases)
- [Packagist](https://packagist.org/) - Monitor package updates

## Notes

- StudyNexus is well-positioned for Laravel 13 upgrade
- No legacy code patterns detected
- Application uses modern bootstrap configuration
- All dependencies should update smoothly once available
- Estimated effort: 1-2 hours once ecosystem is ready

---

**Last Assessed**: April 8, 2026  
**Assessed By**: Claude Code  
**Status**: Ready for upgrade when Laravel 13 available
