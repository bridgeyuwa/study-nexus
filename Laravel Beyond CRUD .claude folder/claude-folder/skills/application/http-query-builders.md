# HTTP Query Builders

HTTP query builders map URL query parameters to Eloquent queries. They belong in the application layer and keep controllers thin.

---

## The Problem

Data tables need filtering, sorting, pagination, and search. Whether you're doing full-page refreshes, using something like Inertia.js, or AJAX — at scale, you'll always need to ask the server for an updated set of data based on given conditions. The naive approach:

```php
// BAD — inline in controller, duplicated across controllers
class InvoicesController
{
    public function index()
    {
        $invoices = QueryBuilder::for(Invoice::class)
            ->allowedFilters('number', 'client')
            ->allowedSorts('number', 'date')
            ->with(['invoicee', 'invoiceLines'])
            ->get();
    }
}
```

Problems:
- Duplicated when another controller needs the same query
- No static analysis on the base query
- Controllers get fat as queries grow complex

---

## The Solution: Dedicated Query Builder Classes

```php
namespace App\Admin\Invoices\Queries;

use Illuminate\Http\Request;
use Domain\Invoices\Models\Invoice;
use Spatie\QueryBuilder\QueryBuilder;

class InvoiceIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Invoice::query()
            ->with([
                'invoicee.contact',
                'invoiceLines.article',
            ]);

        parent::__construct($query, $request);

        $this
            ->allowedFilters('number', 'client')
            ->allowedSorts('number', 'date');
    }
}
```

---

## Injecting Into Controllers

Since `Request` is registered in the container, the query builder resolves via autowiring:

```php
class InvoicesController
{
    public function index(InvoiceIndexQuery $query)
    {
        $invoices = $query->paginate();

        return InvoiceResource::collection($invoices);
    }
}
```

The controller knows nothing about filtering/sorting logic. It just gets the query.

---

## Controller-Specific Modifications

The query builder is still fully Eloquent — you can modify it per-controller:

```php
class PaidInvoicesController
{
    public function index(InvoiceIndexQuery $invoiceQuery)
    {
        // Reuse all the shared config, add one constraint
        $invoices = $invoiceQuery
            ->whereStatus(InvoiceStatus::PAID())
            ->paginate();
    }
}
```

---

## Advanced: Complex Base Queries with Joins

Before passing to the parent constructor, set up any complex query:

```php
use Spatie\QueryBuilder\AllowedFilter;
use Support\QueryBuilder\FuzzyFilter;

class InvoiceIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Invoice::query()
            ->join('invoicees', 'invoicees.invoice_id', '=', 'invoices.id')
            ->join('contacts', 'invoicees.contact_id', '=', 'contacts.id');

        parent::__construct($query, $request);

        $this->allowedFilters([
            'number',
            AllowedFilter::custom('search', new FuzzyFilter(
                'contacts.name',
                'contacts.email',
            )),
        ]);
    }
}
```

---

## Injecting Into View Models

You can pass the query builder to a view model instead of resolving directly in the controller:

```php
class InvoicesController
{
    public function index(InvoiceIndexQuery $invoiceQuery)
    {
        $viewModel = new InvoiceIndexViewModel($invoiceQuery);
        return view('invoices.index', $viewModel);
    }
}

class InvoiceIndexViewModel
{
    public function __construct(private InvoiceIndexQuery $query) {}

    public function invoices(): LengthAwarePaginator
    {
        return $this->query->paginate(25);
    }

    public function totalCount(): int
    {
        return $this->query->count();
    }
}
```

---

## Where They Live

```
Http/Invoices/Queries/
    InvoiceIndexQuery.php
    InvoiceCollectionIndexQuery.php
```

Note: These are **HTTP** query builders (mapping URL params to SQL). This is distinct from **Eloquent** query builders (extending `Builder` in the domain layer).

---

## Naming Clarity

Two different "query builders" exist in this architecture:

| Type | Location | Purpose |
|---|---|---|
| **Eloquent Query Builder** | `Domain/*/QueryBuilders/` | Extends `Illuminate\Database\Eloquent\Builder`. Encapsulates reusable Eloquent scopes. |
| **HTTP Query Builder** | `Http/*/Queries/` | Extends `Spatie\QueryBuilder\QueryBuilder`. Maps HTTP params to SQL. |

---

## Package Reference

- `spatie/laravel-query-builder` — maps `filter[]`, `sort`, `include`, `fields` URL params to Eloquent queries with allowed-list safety
