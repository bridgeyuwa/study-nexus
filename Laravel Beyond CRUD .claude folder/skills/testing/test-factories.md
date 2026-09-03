# Test Factories

Custom test factory classes provide a type-safe, composable, immutable alternative for building test data. They work alongside Laravel 8+ model factories and extend the pattern to DTOs, events, and request objects.

---

## Laravel 8+ Factories

Laravel 8 introduced class-based model factories with much better static analysis support:

```php
$user = User::factory()->make();
$invoice = Invoice::factory()->create();
```

These built-in factories are excellent for models. However, they **only build models**. What about data objects, events, or request objects? That's where custom factories come in.

---

## The Custom Factory Pattern

A test factory is a plain PHP class. No base class required. No interfaces. Just patterns.

### Basic Structure

```php
class InvoiceDataFactory
{
    private static int $number = 0;

    public static function new(): self
    {
        return new self();
    }

    public function create(array $extra = []): InvoiceData
    {
        self::$number += 1;

        return InvoiceData::create(array_merge([
            'number' => 'I-' . self::$number,
            'status' => PendingInvoiceState::class,
        ], $extra));
    }
}
```

Usage:

```php
it('will test something', function () {
    $invoiceData = InvoiceDataFactory::new()->create();
});
```

**Why `new()` and not `make()`?** `make` and `create` imply result production. `new` is just construction — the intent is declared by the chained method.

---

## Making Factories Configurable

Add fluent configuration methods:

```php
class InvoiceFactory
{
    private ?string $status = null;
    private ?PaymentFactory $paymentFactory = null;
    private ?Carbon $expiresAt = null;

    public static function new(): self
    {
        return new self();
    }

    public function paid(PaymentFactory $paymentFactory = null): self
    {
        $clone = clone $this; // IMMUTABLE — always clone
        $clone->status = PaidInvoiceState::class;
        $clone->paymentFactory = $paymentFactory ?? PaymentFactory::new();
        return $clone;
    }

    public function expiresAt(string|Carbon $date): self
    {
        $clone = clone $this;
        $clone->expiresAt = Carbon::parse($date);
        return $clone;
    }

    public function create(array $extra = []): Invoice
    {
        $invoice = Invoice::create(array_merge([
            'status'     => $this->status ?? PendingInvoiceState::class,
            'expires_at' => $this->expiresAt ?? now()->addDays(30),
            'number'     => 'I-' . (++self::$number),
        ], $extra));

        if ($this->paymentFactory) {
            $this->paymentFactory->forInvoice($invoice)->create();
        }

        return $invoice;
    }
}
```

---

## Immutability — The Critical Rule

Every configuration method MUST clone `$this` and return the clone. Never mutate in place.

```php
// RIGHT — immutable
public function paid(): self
{
    $clone = clone $this;
    $clone->status = PaidInvoiceState::class;
    return $clone;
}

// WRONG — mutates original
public function paid(): self
{
    $this->status = PaidInvoiceState::class;
    return $this;
}
```

**Why immutability matters:**

```php
$factory = InvoiceFactory::new()->expiresAt('2023-01-01');

$invoiceA = $factory->paid()->create();   // paid, expires 2023-01-01
$invoiceB = $factory->create();           // pending, expires 2023-01-01 ✓

// Without immutability: $invoiceB would also be paid. Bug.
```

---

## Factories Within Factories

Pass child factories as arguments to control their configuration from outside:

```php
// Paid with a specific payment type
$invoice = InvoiceFactory::new()
    ->paid(PaymentFactory::new()->type(VisaPaymentType::class))
    ->create();

// Paid late (after expiry)
$invoice = InvoiceFactory::new()
    ->expiresAt('2023-01-01')
    ->paid(PaymentFactory::new()->paidAt('2022-05-20'))
    ->create();
```

### Comparison with Laravel 8+ Factories

The same scenario using Laravel's built-in factories:

```php
$invoice = Invoice::factory()
    ->has(
        Payment::factory()
            ->state(['paid_at' => '2022-05-20'])
    )
    ->state([
        'expires_at' => '2023-01-01',
        'state' => PaidInvoiceState::class,
    ])
    ->create();
```

Both approaches work. Laravel 8+ factories can also be extended with custom methods to achieve a similar API:

```php
$invoice = Invoice::factory()
    ->expiresAt('2023-01-01')
    ->paid(Payment::factory()->paidAt('2022-05-20'))
    ->create();
```

Custom factories are still valuable for DTOs, events, request objects, and any non-model test data.

---

## Factories for Data Objects

Factories aren't just for models. Use them for data objects in action tests:

```php
class InvoiceDataFactory
{
    private array $lineFactories = [];

    public static function new(): self
    {
        return new self();
    }

    public function addInvoiceLineDataFactory(InvoiceLineDataFactory $factory): self
    {
        $clone = clone $this;
        $clone->lineFactories[] = $factory;
        return $clone;
    }

    public function create(): InvoiceData
    {
        return new InvoiceData(
            lines: array_map(
                fn(InvoiceLineDataFactory $f) => $f->create(),
                $this->lineFactories
            )
        );
    }
}
```

---

## In Tests — The Setup/Execute/Assert Pattern

```php
it('can save an invoice', function () {
    // SETUP
    $invoiceData = InvoiceDataFactory::new()
        ->addInvoiceLineDataFactory(
            InvoiceLineDataFactory::new()
                ->withDescription('Line A')
                ->withItemAmount(1)
                ->withItemPrice(10_00)
        )
        ->addInvoiceLineDataFactory(
            InvoiceLineDataFactory::new()
                ->withDescription('Line B')
                ->withItemAmount(3)
                ->withItemPrice(33_00)
        )
        ->create();

    // EXECUTE
    $invoice = app(CreateInvoiceAction::class)->execute($invoiceData);

    // ASSERT
    $this->assertDatabaseHas($invoice->getTable(), ['id' => $invoice->id]);
    expect($invoice->number)->not()->toBeNull();
    expect($invoice->total_price)->toEqual(1 * 10_00 + 3 * 33_00);
    expect($invoice->invoiceLines)->toHaveCount(2);
});
```

---

## What NOT to Test with Factories

Factories build data for integration tests — tests of business logic that requires database state. For pure unit tests (e.g., a state class, a calculator) you don't need factories at all.
