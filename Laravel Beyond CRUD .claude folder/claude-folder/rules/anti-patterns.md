# Anti-Patterns to Avoid

Everything *Laravel Beyond CRUD* explicitly warns against. Use this as a code review checklist.

---

## 1. Fat Models

**The pattern:** Putting business logic, calculations, and side effects directly in Eloquent models.

```php
// ANTI-PATTERN
class Invoice extends Model
{
    // Calculates on every read — performance problem
    public function getTotalPriceAttribute(): int
    {
        return $this->invoiceLines->reduce(
            fn(int $total, InvoiceLine $line) => $total + $line->total_price,
            0
        );
    }

    // Side effect in a model — belongs in an action
    public function send(): void
    {
        Mail::to($this->client)->send(new InvoiceMail($this));
        $this->update(['sent_at' => now()]);
    }

    // Service location — bad
    public function toPdf(): string
    {
        return app(PdfGenerator::class)->generate($this);
    }
}
```

**Fix:** Move calculations to actions. Store calculated values. Let models only read pre-computed data.

---

## 2. Business Logic in Controllers

**The pattern:** Controllers that grow to contain business rules, conditional logic, and multi-step operations.

```php
// ANTI-PATTERN
class InvoicesController
{
    public function store(InvoiceRequest $request)
    {
        $invoice = Invoice::create($request->validated());

        foreach ($request->lines as $line) {
            $price = $line['amount'] * $line['unit_price'];
            if ($line['vat_included']) {
                $price = $price * 1.21;
            }
            $invoice->lines()->create([...$line, 'total_price' => $price]);
        }

        $pdf = PDF::loadView('invoices.pdf', compact('invoice'));
        Storage::put("invoices/{$invoice->id}.pdf", $pdf->output());

        Mail::to($invoice->client)->send(new InvoiceMail($invoice, $pdf));

        return redirect()->route('invoices.index');
    }
}
```

**Fix:** Extract to `CreateInvoiceAction`. The controller becomes 2-3 lines.

---

## 3. Business Logic in Jobs

**The pattern:** Jobs that do actual work instead of delegating to actions.

```php
// ANTI-PATTERN
class SendInvoiceMailJob implements ShouldQueue
{
    public function handle(): void
    {
        $pdf = PDF::loadView('invoices.pdf', ['invoice' => $this->invoice]);
        Mail::to($this->invoice->client)
            ->cc($this->invoice->accountant)
            ->send(new InvoiceMail($this->invoice, $pdf));
        $this->invoice->update(['mailed_at' => now()]);
        InvoiceMailLog::create(['invoice_id' => $this->invoice->id]);
    }
}
```

**Fix:** Move all of this to `SendInvoiceMailAction`. The job becomes a one-liner delegating to the action.

---

## 4. View Composers for Complex Data

**The pattern:** Registering view composers globally to inject view data from hidden service providers.

```php
// ANTI-PATTERN — hidden, implicit, hard to track
class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('invoices.form', function ($view) {
            $view->with('categories', Category::allowedForUser(auth()->user())->get());
            $view->with('clients', Client::all());
        });
    }
}

// Controller reveals nothing about what the view receives
class InvoicesController
{
    public function create()
    {
        return view('invoices.form'); // what variables does this view have? mystery.
    }
}
```

**Fix:** Use an `InvoiceFormViewModel`. The controller explicitly constructs and passes it.

---

## 5. Grouping Application Code by Technical Type (Not Feature)

**The pattern:** All controllers together, all requests together, all view models together.

```
// ANTI-PATTERN — after a year this is unnavigable
App/Admin/
    Controllers/
        InvoicesController.php
        CustomersController.php
        PaymentsController.php
        ... 40 more files
    Requests/
        InvoiceRequest.php
        CustomerRequest.php
        ... 40 more files
    ViewModels/
        InvoiceViewModel.php
        CustomerViewModel.php
        ... 40 more files
```

**Fix:** Group by feature module. `App/Admin/Invoices/` contains all invoice-related app code.

---

## 6. Using Raw Arrays Instead of Data Objects

**The pattern:** Passing untyped arrays as data carriers between layers.

```php
// ANTI-PATTERN
function createInvoice(array $data): Invoice
{
    // What's in $data? No one knows without reading the caller.
    // $data['client_id']? $data['clientId']? $data['client']->id?
}

// Caller
createInvoice([
    'client_id' => $client->id,
    'lines' => $lines, // array of what?
    'due_at' => $date,
]);
```

**Fix:** Use a typed `InvoiceData` data object. All fields are known, typed, and IDE-visible.

---

## 7. Query Scopes on Models Instead of Query Builder Classes

**The pattern:** Adding query scopes directly to the model, making the model file grow.

```php
// ANTI-PATTERN — model accumulates all query logic
class Invoice extends Model
{
    public function scopeWhereOverdue($query) { ... }
    public function scopeWherePaid($query) { ... }
    public function scopeWhereForClient($query, $clientId) { ... }
    public function scopeWhereInDateRange($query, $from, $to) { ... }
    // ... 15 more scopes
}
```

**Fix:** Move to `InvoiceQueryBuilder extends Builder`, wire via `newEloquentBuilder()`.

---

## 8. Magic Strings for State/Type Values

**The pattern:** Hard-coding string values for states and types throughout the codebase.

```php
// ANTI-PATTERN
$invoice->update(['status' => 'paid']);
if ($invoice->status === 'pending') { ... }
Invoice::where('status', 'paid')->get();
```

**Fix:** Use native PHP 8.1 enums or state classes. Changes to the value name cascade correctly.

---

## 9. Mixing Application Code Into the Domain

**The pattern:** Domain classes that import and depend on HTTP request classes.

```php
// ANTI-PATTERN — domain class knows about HTTP
namespace Domain\Invoices\DataTransferObjects;

use Illuminate\Http\Request; // HTTP concern in the domain

class InvoiceData
{
    public static function fromRequest(Request $request): self
    {
        // The domain now depends on the application layer
    }
}
```

**Note:** The book acknowledges this as a pragmatic trade-off for the `fromRequest()` pattern when using typed request classes. Using `spatie/laravel-data` with controller injection avoids this issue entirely — the data object is constructed by the framework without the domain needing to know about HTTP.

---

## 10. Global State in Tests (Non-Immutable Factories)

**The pattern:** Mutable test factories where calling a configuration method on a factory changes it permanently.

```php
// ANTI-PATTERN — mutable factory
$factory = InvoiceFactory::new()->expiresAt('2023-01-01');
$invoiceA = $factory->paid()->create(); // mutates $factory
$invoiceB = $factory->create();         // also paid! unintended.
```

**Fix:** Every configuration method clones `$this` and returns the clone.
