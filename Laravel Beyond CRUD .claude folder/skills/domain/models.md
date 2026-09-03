# Models

Models are the third core building block, alongside data objects and Actions. Their job is to represent and provide data from the database — nothing more.

---

## Core Principle: Models ≠ Business Logic

Models should NOT:
- Calculate derived values (e.g., `$invoice->total_price` computing a sum)
- Send mail
- Generate PDFs
- Perform complex operations

Models SHOULD:
- Define Eloquent relations
- Define casts
- Provide simple accessors for already-stored values
- Delegate to custom query builders
- Delegate to custom collection classes
- Map generic events to specific event classes

---

## What NOT to Do (Fat Model Anti-Pattern)

```php
// BAD — model doing calculation
class InvoiceLine extends Model
{
    public function getTotalPriceAttribute(): int
    {
        $vatCalculator = app(VatCalculator::class); // service location!
        $price = $this->item_amount * $this->item_price;

        if ($this->price_excluding_vat) {
            $price = $vatCalculator->totalPrice($price, $this->vat_percentage);
        }

        return $price;
    }
}
```

---

## What TO Do — Pre-Calculate via Actions

Calculate values in actions, store them, read them from the model:

```php
class CreateInvoiceLineAction
{
    public function __construct(
        private VatCalculator $vatCalculator,
    ) {}

    public function execute(InvoiceLineData $data): InvoiceLine
    {
        $totalPrice = $this->vatCalculator->calculate(...);

        return InvoiceLine::create([
            'total_price' => $totalPrice, // stored, not calculated on read
        ]);
    }
}

// Model just reads the stored value
$invoiceLine->total_price; // simple attribute access, no computation
```

**Advantages:**
- Performance: calculated once, not on every access
- Queryable: `->where('total_price', '>', 1000)` works
- No side effects on read

---

## Custom Query Builder Classes

Move query scopes to dedicated builder classes:

```php
namespace Domain\Invoices\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Domain\Invoices\States\Paid;

class InvoiceQueryBuilder extends Builder
{
    public function wherePaid(): self
    {
        return $this->whereState('status', Paid::class);
    }
}
```

Wire it up in the model:

```php
class Invoice extends Model
{
    public function newEloquentBuilder($query): InvoiceQueryBuilder
    {
        return new InvoiceQueryBuilder($query);
    }
}

// Usage — fully type-hinted, IDE-aware
Invoice::query()->wherePaid()->get();
```

---

## Custom Collection Classes

Move collection logic out of models and controllers:

```php
namespace Domain\Invoices\Collections;

use Illuminate\Database\Eloquent\Collection;
use Domain\Invoices\Models\InvoiceLine;

class InvoiceLineCollection extends Collection
{
    public function creditLines(): self
    {
        return $this->filter(fn(InvoiceLine $line) => $line->isCreditLine());
    }
}
```

Wire it up in the model:

```php
class InvoiceLine extends Model
{
    public function newCollection(array $models = []): InvoiceLineCollection
    {
        return new InvoiceLineCollection($models);
    }

    public function isCreditLine(): bool
    {
        return $this->price < 0.0;
    }
}
```

Usage:

```php
$invoice->invoiceLines->creditLines();
```

---

## Event-Driven Models

Instead of model observers, remap generic events to specific typed event classes:

```php
class Invoice extends Model
{
    protected $dispatchesEvents = [
        'saving'   => InvoiceSavingEvent::class,
        'deleting' => InvoiceDeletingEvent::class,
    ];
}
```

Specific event class:

```php
class InvoiceSavingEvent
{
    public function __construct(
        public Invoice $invoice,
    ) {}
}
```

Dedicated subscriber (NOT a model observer):

```php
class InvoiceSubscriber
{
    public function __construct(
        private CalculateTotalPriceAction $calculateTotalPriceAction,
    ) {}

    public function saving(InvoiceSavingEvent $event): void
    {
        $invoice = $event->invoice;
        $invoice->total_price = ($this->calculateTotalPriceAction)($invoice);
    }

    public function subscribe(Dispatcher $dispatcher): void
    {
        $dispatcher->listen(InvoiceSavingEvent::class, self::class . '@saving');
    }
}
```

Register in `EventServiceProvider`:

```php
protected $subscribe = [
    InvoiceSubscriber::class,
];
```

**Benefits over observers:**
- Subscribers can have injected dependencies
- Each event has a typed class (not magic strings)
- Testable in isolation — call the subscriber method directly

---

## Responding to the "Anemic Model" Concern

Martin Fowler's anemic domain model anti-pattern argues against models that are "empty bags of data."

The counter-argument: models are NOT empty bags. Via accessors and casts they provide a rich layer between raw database data and domain-ready objects. The business LOGIC moves to actions, but the business DATA and its presentation stays in models.

Alan Kay (who coined OOP) advocated for separating process and data. This architecture leans on that vision.

---

## Model Folder Location

```
Domain/Invoices/Models/
    Invoice.php
    InvoiceLine.php
```

```
Domain/Invoices/QueryBuilders/
    InvoiceQueryBuilder.php

Domain/Invoices/Collections/
    InvoiceLineCollection.php
```
