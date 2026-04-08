# Laravel 13 Upgrade Guide

**Status**: ✅ Completed  
**Upgraded To**: Laravel 13.4.0  
**Completed**: April 8, 2026  

## Overview

StudyNexus was upgraded from Laravel 12 to Laravel 13 as part of ongoing framework maintenance. This document records what changed, what required attention, and any ongoing workarounds.

---

## What Changed

### Framework & Core

| Package | Before | After |
|---------|--------|-------|
| `laravel/framework` | ^12.0 | ^13.0 (13.4.0) |
| `php` | ^8.4 | ^8.3 |
| `laravel/tinker` | ^2.x | ^3.0 |
| `pestphp/pest` | ^3.x | ^4.0 |
| `pestphp/pest-plugin-laravel` | ^3.x | ^4.1.0 |
| `phpunit/phpunit` | ^11.x | ^12.0 |

### Ecosystem Packages Updated

| Package | Version |
|---------|---------|
| `barryvdh/laravel-debugbar` | ^4.2.5 |
| `spatie/geocoder` | ^4.0 |
| `spatie/laravel-backup` | ^10.2.1 |
| `livewire/livewire` | v4 (4.2.4) |

### Self-Healing URLs — Requires Workaround

`lukeraymonddowning/self-healing-urls` v0.7.0 declares `laravel/framework ^10.0|^11.0|^12.0` but works fine with Laravel 13. Two steps were required:

**1. Inline Composer repository override** in `composer.json`:
```json
"repositories": [
    {
        "type": "package",
        "package": {
            "name": "lukeraymonddowning/self-healing-urls",
            "version": "0.7.0",
            "require": {
                "php": "^8.1|^8.2|^8.3|^8.4",
                "laravel/framework": "^10.0|^11.0|^12.0|^13.0"
            },
            "autoload": {
                "psr-4": {
                    "Lukeraymonddowning\\SelfHealingUrls\\": "src/"
                }
            },
            "extra": {
                "laravel": {
                    "providers": [
                        "Lukeraymonddowning\\SelfHealingUrls\\Providers\\SelfHealingUrlsServiceProvider"
                    ]
                }
            },
            "source": {
                "url": "https://github.com/lukeraymonddowning/self-healing-urls.git",
                "type": "git",
                "reference": "v0.7.0"
            }
        }
    }
]
```

**2. Manual service provider registration** in `bootstrap/providers.php`:
```php
use Lukeraymonddowning\SelfHealingUrls\Providers\SelfHealingUrlsServiceProvider;

return [
    AppServiceProvider::class,
    NovaServiceProvider::class,
    SelfHealingUrlsServiceProvider::class,
];
```

> **Why**: When using a Composer inline `package` repository, the `extra.laravel` field is NOT written to `vendor/composer/installed.json`, so `php artisan package:discover` doesn't find the provider. Manual registration is the workaround.

> **To clean up**: Once `lukeraymonddowning/self-healing-urls` publishes a release with `^13.0` in its constraint, remove the inline repository from `composer.json` and the manual entry from `bootstrap/providers.php` (auto-discovery will take over).

---

## No Action Required

The following Laravel 13 breaking changes did **not** affect StudyNexus:

| Breaking Change | Reason Not Applicable |
|---|---|
| `VerifyCsrfToken` renamed to `PreventRequestForgery` | Already using `validateCsrfTokens()` in `bootstrap/app.php` |
| Cache serialization class allow-lists | Uses database driver; no complex object serialization |
| Queue event property renames | No queue jobs in the application |
| Container nullable class behavior | No custom container bindings affected |

---

## Upgrade Steps Performed

```bash
# Update composer.json constraints
composer require laravel/framework:^13.0 laravel/tinker:^3.0 --no-update
composer require barryvdh/laravel-debugbar:^4.2.5 spatie/geocoder:^4.0 spatie/laravel-backup:^10.2.1 --dev --no-update
composer require pestphp/pest:^4.0 pestphp/pest-plugin-laravel:^4.1.0 --dev --no-update
composer require phpunit/phpunit:^12.0 --dev --no-update

# Resolve all dependencies
composer update -W

# Restore self-healing-urls with inline repo + manual provider (see above)

# Clear caches
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Verify
php artisan --version  # Laravel Framework 13.x.x
php artisan test --compact
```

---

## Post-Upgrade State

- All tests passing (`php artisan test --compact`)
- Livewire upgraded from v3 to v4 as part of dependency resolution
- No Blade template changes required
- No route changes required
- No migration changes required

---

**Upgraded By**: Claude Code  
**Branch**: `claude/investigate-removed-package-HHlGs`  
**PR**: merged into main via standard review flow
