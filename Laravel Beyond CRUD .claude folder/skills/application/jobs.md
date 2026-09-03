# Jobs

Jobs belong in the application layer. They manage queue infrastructure — they do NOT contain business logic. Business logic lives in actions.

---

## Jobs Are Like Controllers (for Queues)

| | Controllers | Jobs |
|---|---|---|
| Receives input from | HTTP Request | Developer (serialized data) |
| Dispatched during | HTTP request | Queue worker |
| Supports middleware | Yes | Yes |
| Output | HTTP response | Database writes, mail, etc. |
| Contains business logic | No — delegates to actions | No — delegates to actions |

Just as controllers delegate to actions, jobs delegate to actions.

---

## Job Responsibility: Queue Infrastructure Only

Jobs configure:
- Whether they are queueable (`ShouldQueue`)
- Queue name and connection
- Retry attempts and backoff
- Timeouts
- Chaining with other jobs
- Unique constraints

They do NOT:
- Calculate prices
- Build complex data structures
- Make business decisions

---

## The Pattern: Job → Action

```php
class SendInvoiceMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Invoice $invoice,
    ) {}

    // Laravel injects the action — NOT business logic in the job
    public function handle(SendInvoiceMailAction $sendInvoiceMailAction): void
    {
        $sendInvoiceMailAction->execute($this->invoice);
    }
}
```

Dispatch it:

```php
dispatch(new SendInvoiceMailJob($invoice));
```

---

## Simplified: Generic Action Jobs (spatie/laravel-queueable-action)

Writing a dedicated `*Job` class for every action is boilerplate. The package eliminates this:

```php
// Add the trait to your action
use Spatie\LaravelQueueableAction\QueueableAction;

class SendInvoiceMailAction
{
    use QueueableAction;

    public function execute(Invoice $invoice): void
    {
        // send the mail, track it, etc.
    }
}

// Instead of: dispatch(new SendInvoiceMailJob($invoice));
// Write:
$this->sendInvoiceMailAction->onQueue()->execute($invoice);
```

The package creates a generic job under the hood. IDE autocompletion on `execute()` still works.

---

## When You DO Need a Dedicated Job Class

Use a dedicated job class when the job itself has non-trivial infrastructure concerns:

```php
class ProcessInvoiceBatchJob implements ShouldQueue
{
    use Batchable;

    public int $tries = 3;
    public int $backoff = 60;
    public int $timeout = 300;

    public function __construct(
        private int $invoiceId,
        private string $batchId,
    ) {}

    public function handle(ProcessInvoiceAction $action): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        $invoice = Invoice::findOrFail($this->invoiceId);
        $action->execute($invoice);
    }
}
```

Complex retry logic, batching, timeouts, unique jobs — these justify a dedicated class.

---

## Business Logic That Runs Async Still Lives in Actions

"Sending an invoice mail" is domain behaviour:
- Track which client received which mails
- Conditionally attach different PDFs based on client type
- Log the event

All of this lives in `SendInvoiceMailAction`, not in the job. The job just queues the action.

---

## Where Jobs Live

Jobs live in the application layer, not the domain — they know about queue infrastructure (a framework concern).

---

## Package Reference

- `spatie/laravel-queueable-action` — dispatch any action as a queued job without writing a dedicated job class
