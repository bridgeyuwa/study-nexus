# Testing Domain Code

Domain code is tested with integration tests (require database) and unit tests (pure PHP). The factory pattern makes both practical.

---

## The Testing Philosophy

> "If all your actions are properly unit tested, you can be very confident that the bulk of functionality works as intended. Now it's only a matter of using these actions in ways that make sense for the end user."

Domain tests focus on **business rules**, not HTTP. No `$this->get()`, no fake routes, no response assertions.

The universal test pattern: **Setup → Execute → Assert**

---

## Testing Data Objects

Pure data objects with only typed properties need **no tests**. The type system is the test.

Only test data objects that have static constructors (`fromRequest()`, `fromArray()`, etc.):

```php
it('will correctly map a request to booking data', function () {
    $unit = UnitFactory::new()->create();

    $dataObject = BookingData::fromStoreRequest(new BookingStoreRequest([
        'name'       => 'test',
        'unit_id'    => $unit->id,
        'date_start' => '2022-12-01',
        'date_end'   => '2022-12-05',
    ]));

    expect($dataObject)->toBeInstanceOf(BookingData::class);
    // Type checks cover everything else — no need to assert individual fields
});

it('will not work when unit id is missing', function () {
    BookingData::fromStoreRequest(new BookingStoreRequest([
        'name' => 'test',
        'date_start' => '2022-12-01',
        'date_end' => '2022-12-05',
    ]));
})->throws(ModelNotFoundException::class);
```

---

## Testing Actions

Test two things:
1. The action does what it should (output, database state)
2. It correctly uses its composed sub-actions (implicitly, not by testing sub-action internals)

```php
it('can save an invoice', function () {
    // Setup
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

    // Execute
    $invoice = app(CreateInvoiceAction::class)->execute($invoiceData);

    // Assert
    $this->assertDatabaseHas($invoice->getTable(), ['id' => $invoice->id]);
    expect($invoice->number)->not()->toBeNull();

    $expectedTotalPrice = 1 * 10_00 + 3 * 33_00;
    expect($invoice->total_price)->toEqual($expectedTotalPrice);
    expect($invoice->invoiceLines)->toHaveCount(2);
});
```

**Rule:** Test `CreateInvoiceAction`'s behaviour at the invoice level. Trust that `CreateInvoiceLineAction` works — it has its own test.

---

## Mocking Action Dependencies

For IO-heavy sub-actions (PDF generation, email), mock them via the container:

```php
namespace Tests\Mocks\Actions;

use Domain\Pdf\Actions\GeneratePdfAction;

class MockGeneratePdfAction extends GeneratePdfAction
{
    public static function setup(): void
    {
        app()->singleton(
            GeneratePdfAction::class,
            fn() => new self(),
        );
    }

    public function execute(ToPdf $toPdf): void
    {
        // Do nothing — skip PDF generation in tests
    }
}
```

In your test setup:

```php
beforeEach(function () {
    MockGeneratePdfAction::setup();
});
```

Now `CreateInvoiceAction` will use the mock automatically (via constructor DI from the container).

---

## Testing States

Each state is independently testable — no HTTP, no factory needed:

```php
test('the color of the pending state is orange', function () {
    $invoice = InvoiceFactory::new()->create();
    $state = new PendingInvoiceState($invoice);

    expect($state->colour())->toBe('orange');
});

test('a paid invoice does not need payment', function () {
    $invoice = InvoiceFactory::new()->paid()->create();
    $state = new PaidInvoiceState($invoice);

    expect($state->mustBePaid())->toBeFalse();
});
```

---

## Testing Custom Collections

```php
test('onlyNegatives will only return negative lines', function () {
    $factory = InvoiceLineFactory::new();
    $negativeLine = $factory->withItemPrice(-1_00)->create();

    $collection = new InvoiceLineCollection([
        $negativeLine,
        $factory->withItemPrice(1_00)->create(),
    ]);

    expect($collection->onlyNegatives())->toHaveCount(1);
    expect($negativeLine->is($collection->onlyNegatives()->first()))->toBeTrue();
});
```

---

## Testing Custom Query Builders

```php
it('can filter on active units', function () {
    $factory = UnitFactory::new();
    $activeUnit   = $factory->active()->create();
    $inactiveUnit = $factory->inactive()->create();

    $countOfActiveUnit = Unit::query()
        ->whereActive()
        ->whereKey($activeUnit->id)
        ->count();
    expect($countOfActiveUnit)->toBe(1);

    $countOfInactiveUnit = Unit::query()
        ->whereActive()
        ->whereKey($inactiveUnit->id)
        ->count();
    expect($countOfInactiveUnit)->toBe(0);
});
```

---

## Testing Event Subscribers

Don't go through the model — call the subscriber method directly:

```php
test('saving calculates total price', function () {
    $subscriber = app(InvoiceSubscriber::class);
    $invoice = InvoiceFactory::new()->create();
    $event = new InvoiceSavingEvent($invoice);

    $subscriber->saving($event);

    // Objects are passed by reference — assert on the same invoice
    expect($invoice->total_price)->not()->toBeNull();
});
```

This avoids triggering the full Eloquent event system and tests the subscriber logic in isolation.

---

## What Each Pattern Needs Tested

| Pattern | What to Test | What NOT to Test |
|---|---|---|
| Data object (typed only) | Nothing | — |
| Data object (with `fromX()`) | Mapping correctness, exception cases | Individual field types |
| Action | Output, DB state, sub-action usage | Sub-action internals |
| State | Each method per state class | Model wiring (covered by integration) |
| Transition | State change occurs, side effects fire | State behaviour (test the states) |
| Collection | Custom methods return correct subsets | Base Collection behaviour |
| Query Builder | Custom scopes filter correctly | Eloquent internals |
| Subscriber | Listener method mutates the model correctly | Event registration |
