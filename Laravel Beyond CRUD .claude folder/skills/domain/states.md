# States & Transitions

The state pattern replaces brittle if/else chains with polymorphism. Each state is a first-class class.

---

## The Problem: Scattered Conditionals

You might start with a simple enum to represent state:

```php
enum InvoiceState: string
{
    case Pending = 'pending';
    case Paid = 'paid';

    public function color(): string
    {
        return match($this) {
            self::Pending => 'orange',
            self::Paid => 'green',
        };
    }
}
```

Used on a model:

```php
class Invoice extends Model
{
    public function getStateColour(): string
    {
        return $this->state->color();
    }
}
```

This works for simple cases. But using this approach, the enum (or the model) has to know what a specific state should do and how it works. As states and their behaviour grow, match expressions and conditionals multiply everywhere. This is fragile.

The state pattern turns this around: it treats "a state" as a first-class citizen. Every state is represented by a separate class, and each class acts upon a subject.

---

## The Solution: State Classes

### Step 1 — Abstract base state

```php
abstract class InvoiceState
{
    public function __construct(
        protected Invoice $invoice,
    ) {}

    abstract public function colour(): string;
    abstract public function mustBePaid(): bool;
}
```

### Step 2 — Concrete state classes

```php
class PendingInvoiceState extends InvoiceState
{
    public function colour(): string
    {
        return 'orange';
    }

    public function mustBePaid(): bool
    {
        if ($this->invoice->type != InvoiceType::Debit) {
            return false;
        }

        if ($this->invoice->total_price <= 0) {
            return false;
        }

        return true;
    }
}

class PaidInvoiceState extends InvoiceState
{
    public function colour(): string
    {
        return 'green';
    }

    public function mustBePaid(): bool
    {
        return false;
    }
}
```

### Step 3 — Wire to model

```php
class Invoice extends Model
{
    // state_class column stores the FQCN of the state
    public function getStateAttribute(): InvoiceState
    {
        return new $this->state_class($this);
    }

    // Delegate to state — model stays clean
    public function mustBePaid(): bool
    {
        return $this->state->mustBePaid();
    }

    public function colour(): string
    {
        return $this->state->colour();
    }
}
```

Usage:

```php
$invoice->colour();      // 'orange' or 'green' — no conditions in sight
$invoice->mustBePaid();  // true/false — handled by the state class
```

---

## States Without Transitions (Static Types)

Not all states transition. Some represent a fixed property. Apply the state pattern to eliminate conditionals even here:

```php
abstract class InvoiceType
{
    protected Invoice $invoice;
    abstract public function mustBePaid(): bool;
}

class DebitInvoiceType extends InvoiceType
{
    public function mustBePaid(): bool { return true; }
}

class CreditInvoiceType extends InvoiceType
{
    public function mustBePaid(): bool { return false; }
}
```

Now `PendingInvoiceState::mustBePaid` becomes:

```php
public function mustBePaid(): bool
{
    if ($this->invoice->total_price <= 0) {
        return false;
    }

    return $this->invoice->type->mustBePaid();
}
```

Reducing if/else statements allows code to be more linear, which is easier to reason about.

---

## Transitions

Transitions move a model from one state to another. They are separate classes with possible side effects.

```php
class PendingToPaidTransition
{
    public function __invoke(Invoice $invoice): Invoice
    {
        if (! $invoice->mustBePaid()) {
            throw new InvalidTransitionException(self::class, $invoice);
        }

        $invoice->status_class = PaidInvoiceState::class;
        $invoice->save();

        History::log($invoice, 'Pending to Paid');

        return $invoice;
    }
}
```

**States = read data / provide behaviour.**
**Transitions = write data / side effects.**

This separation keeps each class's responsibility clear.

---

## Testing States

Each state class is independently testable:

```php
test('the color of the pending state is orange', function () {
    $state = new PendingInvoiceState(
        InvoiceFactory::new()->create()
    );

    expect($state->colour())->toBe('orange');
});

test('a paid invoice does not need to be paid', function () {
    $state = new PaidInvoiceState(
        InvoiceFactory::new()->paid()->create()
    );

    expect($state->mustBePaid())->toBeFalse();
});
```

No HTTP, no complex setup — just instantiate the state and assert.

---

## Using spatie/laravel-model-states

Manual state management (storing/loading FQCN, mapping, transitions) gets tedious. Use the package:

```php
use Spatie\ModelStates\HasStates;

class Invoice extends Model
{
    use HasStates;

    protected $casts = [
        'status' => InvoiceState::class,
    ];
}
```

The package handles:
- Casting state strings to/from state class instances
- Defining allowed transitions
- Throwing on invalid transitions
- Transition history

---

## When to Use State vs. Enum

| Use State Pattern | Use Enum |
|---|---|
| Behaviour differs per value | Simple categorisation |
| Complex conditionals based on value | Few or no conditionals |
| Transitions between values needed | Value is fixed at creation |
| Pattern will grow over time | Small, stable set of values |

**Rule of thumb:** When you find yourself attaching more and more value-specific functionality to an enum, convert it to states.

---

## Package Reference

- `spatie/laravel-model-states` — state management for Eloquent models
- `symfony/workflow` — for complex state machines with many states/transitions
