# Naming Conventions

Consistent naming eliminates ambiguity in large codebases.

---

## Suffix All Domain Classes

Always suffix classes with their type. The name alone must never be ambiguous.

| Class | Wrong | Right |
|---|---|---|
| Action | `CreateInvoice` | `CreateInvoiceAction` |
| Data Object | `CustomerData` ✓ | (Data objects are already descriptive) |
| State | `Pending` | `PendingInvoiceState` |
| Transition | `PendingToPaid` | `PendingToPaidTransition` |
| Query Builder | `InvoiceQuery` | `InvoiceIndexQuery` |
| View Model | `InvoiceForm` | `InvoiceFormViewModel` |
| Event | `InvoiceSaving` | `InvoiceSavingEvent` |
| Subscriber | `Invoice` | `InvoiceSubscriber` |
| Factory (test) | `Invoice` | `InvoiceFactory` |
| Collection | `InvoiceLines` | `InvoiceLineCollection` |
| Job | `SendInvoiceMail` | `SendInvoiceMailJob` |

**Why:** `CreateInvoice` could be a controller, a command, a job, a request, or an action. Suffixes eliminate this collision entirely.

**Long names are fine.** IDE autocompletion handles them.

```php
// This is a real class name from a real project. It's fine.
CreateOrUpdateHabitantContractUnitPackageAction
```

---

## Action Method Name: `execute`

Do not use `__invoke` (causes PHP syntax issues when composing actions).
Do not use `handle` (Laravel hijacks it for method injection in jobs/commands).

Use `execute`:

```php
class CreateInvoiceAction
{
    public function execute(InvoiceData $invoiceData): Invoice
    {
        // ...
    }
}
```

---

## Factory Static Constructor: `new`

Test factories use `new()` as their static constructor, NOT `make()` or `create()`:

```php
InvoiceFactory::new()->create();
InvoiceFactory::new()->paid()->create();
```

**Why:** `make` and `create` imply the factory is producing a result. `new` is clearly just instantiation, leaving the intent to the chained methods.

---

## Application Modules Mirror Business Concepts

Within an application, group by feature/module — not by technical type:

```
Http/Invoices/
    Controllers/
    Filters/
    Middleware/
    Queries/
    Requests/
    Resources/
    ViewModels/
```

NOT:

```
Http/
    Controllers/   ← all mixed together
    Requests/      ← all mixed together
    ViewModels/    ← all mixed together
```

---

## Domain Folder Structure Per Business Concept

```
Domain/Invoices/
    Actions/
    Commands/
    Collections/
    DataTransferObjects/
    Events/
    Exceptions/
    Listeners/
    Models/
    QueryBuilders/
    Rules/
    States/
```
