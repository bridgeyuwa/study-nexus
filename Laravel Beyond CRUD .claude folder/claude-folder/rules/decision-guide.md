# Quick Decision Guide

Use this cheat sheet when you're unsure where a class belongs or which pattern to use.

---

## Where Does This Class Go?

```
Is it business logic with no HTTP/queue knowledge?
├── YES → Domain layer
│   ├── Represents data only → DataTransferObjects/
│   ├── Performs a business operation → Actions/
│   ├── Is a domain command → Commands/
│   ├── Is an Eloquent model → Models/
│   ├── Encapsulates state behaviour → States/
│   ├── Categorises named values → use native PHP enum (or States/ if complex behaviour)
│   ├── Extends Eloquent Builder → QueryBuilders/
│   ├── Extends Eloquent Collection → Collections/
│   ├── Is a domain event → Events/
│   ├── Reacts to a domain event → Listeners/
│   ├── Is domain-level invalid input → Exceptions/
│   └── Validates business rules → Rules/
│
└── NO → Application layer
    ├── Handles HTTP requests → Controllers/
    ├── Validates HTTP input → Requests/
    ├── Filters HTTP middleware → Middleware/
    ├── Formats API output → Resources/
    ├── Prepares view data → ViewModels/
    ├── Maps URL params to SQL → Queries/
    ├── Manages queue pipeline → Jobs/
    └── Is an Artisan command → Console/Commands/

Is it globally shared, with no domain home?
└── Support/

Is it cross-cutting domain logic used by multiple domains?
└── Domain/Shared/
```

---

## Which Pattern Should I Use?

**I need to represent structured data from a request/API/form:**
→ **Data Object** (`DataTransferObjects/`). Use `spatie/laravel-data` for validation, casting, and form request replacement.

**I need to execute a business operation:**
→ **Action** (`Actions/`)

**My model has complex state-dependent behaviour:**
→ **State Pattern** (`States/`)

**My model has a simple set of fixed values with no complex behaviour:**
→ **Native PHP 8.1 Enum** (no package needed)

**I need to build complex Eloquent queries that are reused:**
→ **Custom Query Builder** (domain `QueryBuilders/`)

**I need to filter a collection in collection-pipeline style:**
→ **Custom Collection** (`Collections/`)

**I need to prepare data for a Blade view:**
→ **View Model** (`ViewModels/`)

**I need to filter/sort a list page from URL params:**
→ **HTTP Query Builder** (application `Queries/`)

**I need to run an action asynchronously:**
→ **Job** (delegates to action) or `->onQueue()->execute()` via `spatie/laravel-queueable-action`

---

## When to Use State vs. Enum

```
Does the value have different BEHAVIOUR per variant?
├── YES → State Pattern
│   └── Each variant = its own class with methods
└── NO → Native Enum
    └── Just categorisation, maybe one simple match expression

Will more variants with distinct behaviour be added over time?
├── YES → State Pattern (extensible by adding new classes)
└── NO → Enum is fine
```

---

## Action Method Naming

```
__invoke  → AVOID (PHP syntax issue when composing actions via properties)
handle    → AVOID (Laravel hijacks for method injection in jobs)
execute   → USE THIS
```

---

## Factory Configuration Methods

```
public function paid(): self
{
    $clone = clone $this;  // ← ALWAYS clone
    $clone->status = PaidInvoiceState::class;
    return $clone;         // ← return the clone, not $this
}
```

Never mutate `$this` in factory configuration methods. Always clone.

---

## Test Structure Template (Pest)

```php
it('describes the behaviour', function () {
    // SETUP — use factories, build state
    $data = SomeFactory::new()->withVariant()->create();
    $action = app(SomeAction::class);

    // EXECUTE — one meaningful operation
    $result = $action->execute($data);

    // ASSERT — verify observable outcomes
    expect($result->value)->toEqual($expected);
    $this->assertDatabaseHas('table', ['column' => 'value']);
});
```

---

## Data Object Construction (PHP 8+)

```
Plain PHP (simple cases):
→ Constructor property promotion + spread
→ new CustomerData(...$request->validated())

With type casting / validation:
→ Use spatie/laravel-data
→ Extend Spatie\LaravelData\Data
→ Inject data object directly in controller (replaces form request)

Legacy (PHP < 8):
→ Use spatie/data-transfer-object with DocBlocks
→ Array construction: new CustomerData([...])
```

---

## Common Mistakes Quick-Reference

| Symptom | Cause | Fix |
|---|---|---|
| Model file > 200 lines | Business logic in model | Extract to actions + query builders |
| Controller > 30 lines | Business logic in controller | Extract to actions |
| Job contains calculations | Business logic in job | Create an action, delegate |
| `$validated['key']` everywhere | No data objects | Create typed data object |
| `if ($status === 'pending')` chains | No state pattern | Create state classes |
| View data duplicated across controller methods | No view model | Create view model |
| IDE shows no autocompletion on factory result | Factory not typed | Add return type to `create()` |
| Two factories interfere with each other | Mutable factory | Use `clone $this` in config methods |
| Large `Domain/Shared/` folder | Wrong domain boundaries | Restructure domains |
