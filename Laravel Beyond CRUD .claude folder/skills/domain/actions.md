# Actions

Actions are the primary way to represent business operations in the domain. They are single-responsibility classes that take input, do something, and return output.

---

## Core Concept

Every user story becomes an action. Instead of spreading business logic across controllers, models, and jobs — it all lives in one place.

```
User story: "Admin creates an invoice"

Naive approach spreads this across:
  ├── InvoicesController (entry point)
  ├── Invoice model (business logic)  
  ├── GeneratePdfJob (async work)
  └── InvoiceCreatedListener (sends mail)

Action approach:
  └── CreateInvoiceAction (the whole story, start from here)
       ├── uses CreateInvoiceLineAction
       ├── uses GeneratePdfAction
       └── uses SendInvoiceMailAction
```

---

## Anatomy of an Action

```php
class CreateInvoiceAction
{
    public function __construct(
        private CreateInvoiceLineAction $createInvoiceLineAction,
        private GeneratePdfAction $generatePdfAction,
    ) {}

    // Context data injected via execute() — NOT the constructor
    public function execute(InvoiceData $invoiceData): Invoice
    {
        // business logic here
    }
}
```

**Key rules:**
- Lives in the domain
- No interfaces or abstractions required
- One public method: `execute()`
- Constructor = framework DI (services, other actions)
- `execute()` = runtime data (data objects, models)

---

## Why `execute` and Not `__invoke` or `handle`

**`__invoke` problem:** PHP won't let you call an invokable property directly.
```php
// This FAILS
$this->createInvoiceLineAction($lineData);

// You'd need this ugly workaround
($this->createInvoiceLineAction)($lineData);
```

**`handle` problem:** Laravel provides method injection on `handle` in jobs/commands. Actions must only get DI through the constructor — using `handle` breaks this guarantee.

**`execute` is the convention.** It's unambiguous and not hijacked by the framework.

---

## Composing Actions

Actions can depend on other actions. This is composition, not inheritance.

```php
class CreateInvoiceLineAction
{
    public function __construct(
        private VatCalculator $vatCalculator,
    ) {}

    public function execute(InvoiceLineData $data): InvoiceLine
    {
        $item = $data->item;

        if ($item->vatIncluded()) {
            [$priceIncVat, $priceExclVat] = $this->vatCalculator->vatIncluded(
                $item->getPrice(),
                $item->getVatPercentage()
            );
        } else {
            [$priceIncVat, $priceExclVat] = $this->vatCalculator->vatExcluded(
                $item->getPrice(),
                $item->getVatPercentage()
            );
        }

        return new InvoiceLine([
            'item_price'               => $item->getPrice(),
            'total_price'              => $data->item_amount * $priceIncVat,
            'total_price_excluding_vat' => $data->item_amount * $priceExclVat,
        ]);
    }
}
```

Composition chain example:
```
CreateInvoiceAction
  ├── CreateInvoiceLineAction
  │     └── VatCalculator
  ├── GeneratePdfAction
  └── SendInvoiceMailAction
```

**Warning:** Deep dependency chains make code hard to reason about. Keep composition shallow where possible.

---

## Reusability

Actions can be reused across multiple entry points:

```php
// Called from InvoicesController (HTTP)
$action->execute($invoiceData);

// Called from ArtisanCommand (CLI)
$action->execute($invoiceData);

// Called from another action (composition)
$this->createInvoiceAction->execute($invoiceData);

// Dispatched to queue via spatie/laravel-queueable-action
$action->onQueue()->execute($invoiceData);
```

---

## Abstracting Shared Action Behaviour

When multiple models need the same action shape:

```php
interface ToPdf
{
    public function toPdfData(): array;
}

class GeneratePdfAction
{
    public function execute(ToPdf $subject): string
    {
        // works for Invoice, Quote, Contract, etc.
    }
}

class Invoice implements ToPdf { ... }
class Quote implements ToPdf { ... }
```

---

## Actions vs. Commands/Handlers (DDD)

Actions are a simplified command bus. They combine "what" and "how" into one class.

| | Actions | Commands + Handlers |
|---|---|---|
| Separation | Combined | Separate classes |
| Flexibility | Less | More |
| Code volume | Less | More |
| Suitable for | Large-but-not-ginormous apps | Enterprise / high flexibility needs |

---

## Actions vs. Event-Driven Systems

Event-driven systems offer more decoupling but add indirectness. Actions are directly called — you always know what happens when you read the code.

For most Laravel projects, actions strike the right balance.

---

## Running Actions on the Queue

With `spatie/laravel-queueable-action`:

```php
// Instead of:
dispatch(new SendInvoiceMailJob($invoice));

// You write:
$this->sendInvoiceMailAction->onQueue()->execute($invoice);
```

The package creates a generic job class under the hood and dispatches it. No dedicated `*Job` class needed for simple action delegation.

---

## Benefits Summary

1. **Single source of truth** — one place to look when a business rule changes
2. **Reusable** — shared across controllers, jobs, commands, other actions
3. **Testable** — no HTTP, no facades, just instantiate and call `execute()`
4. **Reduces cognitive load** — business logic is no longer scattered
