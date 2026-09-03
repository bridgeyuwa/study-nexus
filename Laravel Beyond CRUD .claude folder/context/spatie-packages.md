# Spatie Package Reference

All packages from the book that support this architecture.

---

## Core Architecture Packages

### spatie/laravel-data
**Docs:** https://spatie.be/docs/laravel-data

The primary data object package. Replaces `spatie/data-transfer-object` for new projects. Data objects can serve as form requests, API resources, and can generate TypeScript definitions.

```php
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Rule;

class CustomerData extends Data
{
    public function __construct(
        public string $name,
        #[Rule('email')]
        public string $email,
        public Carbon $birth_date,
    ) {}
}

// As a form request replacement — inject directly in controller
class CustomerController
{
    public function update(CustomerData $customerData)
    {
        // Already validated and type-cast
    }
}

// As an API resource
return CustomerData::from($customer); // returns JSON-serializable data
```

**Key features:**
- Automatic type casting (string → Carbon, etc.)
- Validation via PHP attributes or dedicated methods
- Form request replacement (inject data object in controller)
- API resource replacement
- TypeScript definition generation
- Nested data objects and typed collections

---

### spatie/laravel-model-states
**GitHub:** https://github.com/spatie/laravel-model-states

State pattern for Eloquent models. Handles storing, loading, casting states, and managing allowed transitions.

```php
use Spatie\ModelStates\HasStates;

class Invoice extends Model
{
    use HasStates;

    protected $casts = [
        'status' => InvoiceState::class,
    ];
}

// Transition
$invoice->status->transitionTo(PaidInvoiceState::class);
```

---

### spatie/laravel-query-builder
**Docs:** https://spatie.be/docs/laravel-query-builder

Maps HTTP query parameters (`filter[]`, `sort`, `include`, `fields[]`) to Eloquent queries with an allow-list for safety.

```php
$invoices = QueryBuilder::for(Invoice::class)
    ->allowedFilters('number', 'client', AllowedFilter::exact('status'))
    ->allowedSorts('number', 'date', 'total_price')
    ->allowedIncludes('invoiceLines', 'client')
    ->paginate();
```

Use as a base class for dedicated query classes:

```php
class InvoiceIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        parent::__construct(Invoice::query()->with('invoicee'), $request);
        $this->allowedFilters('number')->allowedSorts('date');
    }
}
```

---

### spatie/laravel-view-models
**GitHub:** https://github.com/spatie/laravel-view-models

Base class for view models. Adds `Arrayable` (pass directly to view) and `Responsable` (return as JSON) implementations. Also auto-resolves public methods as view variables.

```php
use Spatie\ViewModels\ViewModel;

class PostFormViewModel extends ViewModel
{
    public function __construct(
        private User  $user,
        private ?Post $post = null,
    ) {}

    public function post(): Post
    {
        return $this->post ?? new Post();
    }

    public function categories(): Collection
    {
        return Category::allowedForUser($this->user)->get();
    }
}

// In controller
return view('blog.form', new PostFormViewModel($user, $post));
```

---

### spatie/laravel-queueable-action
**GitHub:** https://github.com/spatie/laravel-queueable-action

Dispatch any action as a queued job without writing a dedicated `*Job` class.

```php
use Spatie\LaravelQueueableAction\QueueableAction;

class SendInvoiceMailAction
{
    use QueueableAction;

    public function execute(Invoice $invoice): void
    {
        // business logic
    }
}

// Sync
$action->execute($invoice);

// Queued
$action->onQueue()->execute($invoice);
```

---

## Legacy Packages (Pre-PHP 8.1)

### spatie/data-transfer-object
**GitHub:** https://github.com/spatie/data-transfer-object

Legacy DTO base class. **Superseded by `spatie/laravel-data`** for all new projects.

### spatie/enum
**GitHub:** https://github.com/spatie/enum

Userland enum implementation. **Superseded by native PHP 8.1 enums.**

### spatie/laravel-enum
**GitHub:** https://github.com/spatie/laravel-enum

Laravel integration for `spatie/enum`. **Superseded by native PHP 8.1 enum casting.**

### myclabs/php-enum
Popular enum package with explicit constant definition. **Superseded by native PHP 8.1 enums.**

---

## External Reference Packages

### symfony/workflow
For complex state machines requiring many states, many transitions, and transition guards. More powerful than `spatie/laravel-model-states`.

---

## Quick Decision: Which Package for Which Need?

| Need | Package |
|---|---|
| Data objects / DTOs | `spatie/laravel-data` |
| State pattern on models | `spatie/laravel-model-states` |
| Type-safe enums | Native PHP 8.1 `enum` (no package needed) |
| Map URL params to queries | `spatie/laravel-query-builder` |
| View models | `spatie/laravel-view-models` |
| Queue actions without Job classes | `spatie/laravel-queueable-action` |
| Complex state machines | `symfony/workflow` |
