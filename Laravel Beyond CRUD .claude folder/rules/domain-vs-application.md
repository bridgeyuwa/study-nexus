# Domain vs Application — Placement Rules

Use these rules to decide where any given class belongs.

---

## Quick Decision Test

Ask: **"Does this class know about HTTP, requests, or user-facing infrastructure?"**

- Yes → Application layer
- No → Domain layer

---

## Domain Layer — What Belongs Here

The domain knows nothing about how it's consumed. It is framework-agnostic in spirit (even if it uses Eloquent).

| Class Type | Notes |
|---|---|
| **Actions** | Business operations. Take data objects as input, return domain objects. |
| **Data Objects (DTOs)** | Typed data containers. Map from external input at boundaries. |
| **Commands** | Domain commands (not Artisan commands). |
| **Models** | Data-oriented only. No business logic, no send/toPdf methods. |
| **States** | Encapsulate state-specific behaviour. Each state is a class. |
| **Transitions** | Handle state changes and their side effects. |
| **Enums** | Native PHP 8.1 enums for named value sets with no complex conditional flows. |
| **Query Builders** | Eloquent query builder extensions on models. |
| **Custom Collections** | Domain-specific collection methods. |
| **Events** | Specific model events remapped from generic Eloquent events. |
| **Listeners / Subscribers** | React to domain events. May call actions. |
| **Exceptions** | Domain-specific exceptions. |
| **Validation Rules** | Business validation rules. |

---

## Application Layer — What Belongs Here

| Class Type | Notes |
|---|---|
| **Controllers** | Receive HTTP input, call actions, return responses. Thin. |
| **Requests** | Laravel form requests with validation rules. (Or use `spatie/laravel-data` to replace them.) |
| **Middleware** | HTTP-level pre/post processing. |
| **Resources** | API output transformation (JSON). Map one-to-one on models. |
| **View Models** | Prepare data for views. Injected explicitly into controllers. |
| **HTTP Query Builders** | Map URL query params to Eloquent queries (spatie/laravel-query-builder). |
| **Jobs** | Queue management only. Delegate to actions for business logic. |
| **Commands** | Artisan commands. Delegate to actions. |
| **Data Object Factories** | (Alternative: construction logic on the data object itself or via `spatie/laravel-data`.) |

---

## The Boundary: Data Object Construction

The one judgment call: **where does the mapping from Request → data object live?**

**Option 1 — `spatie/laravel-data` (recommended):** Data object extends `Data`, inject directly in controller. Package handles validation and type casting.

```php
class CustomerController
{
    public function update(CustomerData $customerData)
    {
        // Already validated and constructed
    }
}
```

**Option 2 — Dedicated factory** in the application layer.

**Option 3 — Static constructor** on the data object itself (`CustomerData::fromRequest($request)`). Pragmatic but mixes layers.

---

## Jobs Are Application, Not Domain

Jobs manage queue infrastructure. They do NOT contain business logic.

```php
// RIGHT — job delegates to action
class SendInvoiceMailJob implements ShouldQueue
{
    public function __construct(
        public Invoice $invoice,
    ) {}

    public function handle(SendInvoiceMailAction $action): void
    {
        $action->execute($this->invoice);
    }
}

// WRONG — business logic in job
class SendInvoiceMailJob implements ShouldQueue
{
    public function handle(): void
    {
        Mail::to($this->invoice->client)->send(new InvoiceMail($this->invoice));
        $this->invoice->update(['mailed_at' => now()]);
    }
}
```

---

## Models Are Domain, But Keep Them Thin

Models live in the domain but must not handle business logic. They are data providers.

**Allowed in models:**
- Eloquent relations
- Casts
- Simple accessors (reading already-calculated values)
- `$dispatchesEvents` mapping
- `newEloquentBuilder()` override
- `newCollection()` override

**Not allowed in models:**
- Calculations (move to Actions)
- Sending mail / generating PDFs (move to Actions)
- Complex query scopes (move to QueryBuilder class)
- Collection manipulation chains (move to Collection class)
- Service location via `app()` (use DI instead)
