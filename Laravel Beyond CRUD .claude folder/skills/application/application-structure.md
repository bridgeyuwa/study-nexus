# Application Layer Structure

How to organise the application layer at scale. The same grouping-by-business-concept principle from the domain layer applies here too.

---

## What Is the Application Layer?

The application layer is the bridge between the outside world and the domain. It:

- Receives input (HTTP requests, CLI args, queue messages)
- Transforms input into domain-understood data (data objects)
- Calls domain actions
- Formats and returns output

All complex logic lives in the domain. Application code is mostly structural — "boring" glue code.

---

## Multiple Applications in One Project

Every Laravel project already has multiple applications by default:

| Application | Purpose |
|---|---|
| HTTP Admin | Back-office for internal users |
| HTTP API | REST/JSON for external clients or SPAs |
| Artisan Console | Developer operations |
| Third-party integrations | Webhooks, cron, event bridges |

Each is an isolated entry point. They share the domain but don't directly call each other.

---

## The Scaling Problem: Flat Technical Grouping

Laravel's default structure groups by technical type:

```
Http/
├── Controllers/   ← 50 files, all mixed
├── Requests/      ← 50 files, all mixed
├── Resources/     ← 50 files, all mixed
└── ViewModels/    ← 50 files, all mixed
```

After a year of development, each folder has 50+ files. Finding invoice-related code requires looking in 4+ directories simultaneously.

---

## The Solution: Feature Modules

Group by business concept WITHIN each application:

```
Http/
├── Invoices/
│   ├── Controllers/
│   ├── Filters/
│   ├── Middleware/
│   ├── Queries/
│   ├── Requests/
│   ├── Resources/
│   └── ViewModels/
├── Customers/
│   ├── Controllers/
│   ├── Requests/
│   ├── Resources/
│   └── ViewModels/
└── Settings/
    ├── Controllers/
    └── ViewModels/
```

Every invoice-related application class is in one folder. Open it and see everything you need.

---

## Modules ≠ Domains (1-to-1 is NOT required)

Application modules and domain groups can differ:

```
Domain/Invoices/          → invoice business logic
Domain/Payments/          → payment business logic

Http/Invoices/            → invoice UI (touches Domain/Invoices + Domain/Payments)
Http/Settings/            → settings UI (touches multiple domains)
```

A "Settings" module might touch 5 different domain groups. It's still one feature from the application perspective — keep it together.

---

## What Goes in Each Module Subfolder

| Folder | Contents |
|---|---|
| `Controllers/` | One controller per resource or action group |
| `Requests/` | Form request validation classes |
| `Middleware/` | Module-specific HTTP middleware |
| `Filters/` | Custom filter classes for query builders |
| `Queries/` | HTTP query builder classes |
| `Resources/` | API resource transformers |
| `ViewModels/` | View data preparation classes |
| `Jobs/` | Queue jobs specific to this module (if needed) |

---

## General-Purpose Application Code → Support

Classes that are shared across all modules in all applications:

- Base request class
- Authentication middleware
- Global exception handler
- Pagination helpers
- Response macros

These go in `Support/` (or `App/Http/` if you prefer staying closer to Laravel conventions):

```
Support/
├── Http/
│   ├── BaseRequest.php
│   └── Middleware/
│       └── AuthenticateMiddleware.php
└── Exceptions/
    └── Handler.php
```

---

## What Belongs in an Application Layer Class

### Controllers — Thin

```php
class InvoicesController
{
    public function store(
        InvoiceRequest $request,
        CreateInvoiceAction $action,
    ): RedirectResponse {
        $invoice = $action->execute(
            InvoiceData::fromRequest($request)
        );

        return redirect()->route('invoices.show', $invoice);
    }
}
```

Controllers should:
- Receive the request
- Call one action (or construct a view model)
- Return a response

They should NOT contain business logic, calculations, or conditional branching based on business rules.

### Jobs — Queue Management Only

```php
class ProcessInvoiceJob implements ShouldQueue
{
    public int $tries = 3;

    public function handle(CreateInvoiceAction $action): void
    {
        $action->execute($this->invoiceData);
    }
}
```

### Commands — Thin Wrappers

```php
class GenerateMonthlyInvoicesCommand extends Command
{
    protected $signature = 'invoices:generate-monthly';

    public function handle(GenerateMonthlyInvoicesAction $action): void
    {
        $action->execute(Carbon::now());
        $this->info('Done.');
    }
}
```

---

## Route Organisation

Mirror the module structure in routes:

```php
// routes/admin.php
Route::prefix('invoices')->name('invoices.')->group(function () {
    Route::get('/', [InvoicesController::class, 'index'])->name('index');
    Route::post('/', [InvoicesController::class, 'store'])->name('store');
    Route::get('/{invoice}', [InvoicesController::class, 'show'])->name('show');
    Route::patch('/{invoice}/status', [InvoiceStatusController::class, 'update'])->name('status.update');
});
```

---

## Testing Application Code

Application layer tests are integration/feature tests:

```php
it('allows an admin to create an invoice', function () {
    $user = UserFactory::new()->admin()->create();
    $client = ClientFactory::new()->create();

    $this->actingAs($user)
         ->post(route('invoices.store'), [
             'client_id' => $client->id,
             'due_at'    => now()->addDays(30)->toDateString(),
         ])
         ->assertRedirect();

    $this->assertDatabaseHas('invoices', ['client_id' => $client->id]);
});
```

Application tests verify routing, middleware, and request/response shape. They don't re-test business logic that's already covered by action tests.
