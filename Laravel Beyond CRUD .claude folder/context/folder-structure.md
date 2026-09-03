# Project Folder Structure

The canonical folder layout for a domain-oriented Laravel project.

---

## Default Structure (Domain Inside `app/`)

For most projects, Spatie recommends keeping the Domain namespace inside the standard `app/` folder. This provides domain-oriented grouping while staying close to Laravel conventions.

```
app/
├── Domain/              ← All business logic, grouped by concept
│   ├── Invoices/
│   ├── Customers/
│   ├── Payments/
│   └── Shared/          ← Cross-cutting domain code (optional)
├── Http/                ← Controllers, middleware, requests, etc.
│   ├── Controllers/
│   ├── Middleware/
│   ├── Requests/
│   ├── Resources/
│   └── ViewModels/
├── Console/
│   └── Commands/
└── Support/             ← Global helpers, base classes
```

No `composer.json` changes are needed for this approach.

---

## Extracted Structure (Optional, for Larger Projects)

If you prefer to fully separate domain and application code into separate root namespaces:

```
src/
├── Domain/          ← All business logic, grouped by concept
├── App/             ← All application layers (HTTP, CLI, API, etc.)
└── Support/         ← Global helpers, base classes, utilities
```

This requires a `composer.json` autoload change:

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "src/App/",
            "Domain\\": "src/Domain/",
            "Support\\": "src/Support/"
        }
    }
}
```

And a custom Application class:

```php
namespace App;

class Application extends \Illuminate\Foundation\Application
{
    protected $namespace = 'App\\';
}
```

```php
// bootstrap/app.php
use App\Application;

$app = (new Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
))->useAppPath('src/App');
```

---

## Domain Layer

One folder per business concept. Each concept has a consistent internal structure:

```
Domain/
├── Invoices/
│   ├── Actions/
│   │   ├── CreateInvoiceAction.php
│   │   ├── CreateInvoiceLineAction.php
│   │   ├── GeneratePdfAction.php
│   │   └── SendInvoiceMailAction.php
│   ├── Commands/
│   ├── Collections/
│   │   └── InvoiceLineCollection.php
│   ├── DataTransferObjects/
│   │   ├── InvoiceData.php
│   │   └── InvoiceLineData.php
│   ├── Events/
│   │   ├── InvoiceSavingEvent.php
│   │   └── InvoiceDeletingEvent.php
│   ├── Exceptions/
│   │   └── InvalidInvoiceStateException.php
│   ├── Listeners/
│   │   └── InvoiceSubscriber.php
│   ├── Models/
│   │   ├── Invoice.php
│   │   └── InvoiceLine.php
│   ├── QueryBuilders/
│   │   └── InvoiceQueryBuilder.php
│   ├── Rules/
│   │   └── ValidInvoiceNumberRule.php
│   └── States/
│       ├── InvoiceState.php            ← abstract
│       ├── PendingInvoiceState.php
│       ├── PaidInvoiceState.php
│       └── Transitions/
│           └── PendingToPaidTransition.php
│
├── Customers/
│   ├── Actions/
│   ├── DataTransferObjects/
│   ├── Models/
│   └── ...
│
├── Payments/
│   ├── Actions/
│   ├── DataTransferObjects/
│   ├── Models/
│   └── ...
│
└── Shared/                              ← Cross-cutting domain code
    ├── Models/
    │   └── Activity.php                 ← e.g. audit log used by all domains
    └── ...
```

### The `Domain/Shared/` Pattern

For code that doesn't belong to any single domain but is used across several. Example: an Activity model providing audit logging used by Invoices, Customers, and Payments.

**Keep `Shared/` small.** A large `Shared/` domain is a sign you need to restructure. Alternatively, you can put common code in `Support/` instead.

---

## Real-World Domain Examples

### Flare (exception tracker)

```
Domain/
├── Account/
├── Error/
├── Flare/
├── Notification/
├── Project/
├── Shared/
└── Subscription/
```

### Mailcoach (email marketing platform)

```
Domain/
├── Audience/
├── Automation/
├── Campaign/
├── Shared/
└── TransactionalMail/
```

Domain names reflect high-level business concepts, not technical categories.

---

## Application Layer (Feature Modules)

Within the HTTP application, group by feature module:

```
Http/
├── Invoices/                   ← Feature module
│   ├── Controllers/
│   │   ├── InvoicesController.php
│   │   ├── InvoiceStatusController.php
│   │   └── MissedInvoicesController.php
│   ├── Filters/
│   ├── Middleware/
│   ├── Queries/
│   │   ├── InvoiceIndexQuery.php
│   │   └── InvoiceCollectionIndexQuery.php
│   ├── Requests/
│   │   └── InvoiceRequest.php
│   ├── Resources/
│   │   ├── InvoiceResource.php
│   │   └── InvoiceLineResource.php
│   └── ViewModels/
│       ├── InvoiceIndexViewModel.php
│       └── InvoiceDraftViewModel.php
│
├── Customers/
│   └── ...
│
└── Settings/                   ← Module that touches multiple domains
    └── ...
```

---

## Support Namespace

For code that has no business-concept home — utilities, base classes, global helpers:

```
Support/
├── ValueObjects/
├── Http/
│   └── BaseRequest.php
└── Testing/
    └── Factory.php          ← Base factory class
```

---

## Tests Mirror the Domain Structure

```
tests/
├── Domain/
│   ├── Invoices/
│   │   ├── Actions/
│   │   │   └── CreateInvoiceActionTest.php
│   │   ├── Collections/
│   │   │   └── InvoiceLineCollectionTest.php
│   │   ├── QueryBuilders/
│   │   │   └── InvoiceQueryBuilderTest.php
│   │   └── States/
│   │       └── InvoiceStateTest.php
│   └── Customers/
│       └── ...
│
└── Factories/
    ├── InvoiceFactory.php
    ├── InvoiceDataFactory.php
    └── PaymentFactory.php
```

---

## Decision Guide: Where Does This Class Go?

1. Is it business logic with no HTTP knowledge? → `Domain/{Concept}/`
2. Does it handle HTTP input/output or queue infrastructure? → `Http/{Module}/` or `App/{Surface}/{Module}/`
3. Is it a global utility or base class? → `Support/`
4. Is it a test helper or factory? → `Tests/Factories/` or `Tests/`
5. Does it cross-cut multiple domains? → `Domain/Shared/` or `Support/`
