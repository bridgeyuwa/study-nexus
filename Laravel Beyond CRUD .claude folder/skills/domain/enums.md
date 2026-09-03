# Enums

Enums categorise named values in a type-safe way. With PHP 8.1+, use **native enums**. Graduate to the State pattern when behaviour per value becomes complex.

---

## When to Use Enums vs. States

| Use Enum | Use State Pattern |
|---|---|
| Simple set of named values | Each value has unique behaviour |
| Few conditionals based on the value | Many conditionals, growing over time |
| Value rarely drives program flow | Value determines different code paths |
| Small, stable set | Complex, potentially expanding set |

If you keep adding methods to your enum that do `match($this) { X => ..., Y => ... }` — convert to states.

---

## Native PHP 8.1 Enums (Default Approach)

PHP 8.1+ has built-in enum support. This is the **primary and default** approach for all new code.

### Basic Enum

```php
enum InvoiceType: string
{
    case Credit = 'credit';
    case Debit  = 'debit';
}
```

### Usage

```php
// Type-safe — only InvoiceType instances accepted
public function setType(InvoiceType $type): void
{
    $this->type = $type;
}

$invoice->setType(InvoiceType::Credit);   // ✓
$invoice->setType('whatever');            // ✗ TypeError

// Construct from string
InvoiceType::from('credit');    // InvoiceType::Credit
InvoiceType::tryFrom('typo');   // null
```

### Enums With Simple Behaviour

Simple methods on native enums are acceptable:

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

    public function label(): string
    {
        return match($this) {
            self::Pending => 'Pending Payment',
            self::Paid => 'Paid',
        };
    }
}
```

This is fine. The moment `mustBePaid()`, `canTransitionTo()`, or complex business rules enter — switch to the State pattern.

### Eloquent Casting

Native enums can be cast directly on Eloquent models:

```php
class Invoice extends Model
{
    protected $casts = [
        'type'   => InvoiceType::class,
        'status' => InvoiceState::class,
    ];
}

// $invoice->type is now an InvoiceType enum instance
$invoice->type === InvoiceType::Credit; // true
```

---

## Enums or States?

The state pattern removes conditionals by providing a dedicated class for each value. Enums keep conditionals but centralise them in `match` expressions.

The state pattern's goal is to get rid of all those conditionals, and instead rely on polymorphism. Use the state pattern to get rid of conditional flows in your code, and enums for everything else.

**Pragmatic rule:** There is room for enums in the codebase. The state pattern has significant overhead (classes for each state, transition configuration, maintenance). Don't overcomplicate your code by always applying the state pattern.

If you need a collection of related values and there are few places where the application flow is determined by those values — use enums. If you find yourself attaching more and more value-related functionality — switch to states.

---

## Legacy: Userland Enum Packages

Before PHP 8.1, enums required userland packages. These are **no longer recommended** for new projects targeting PHP 8.1+.

- `spatie/enum` — enum values derived from DocBlocks. No longer needed.
- `spatie/laravel-enum` — Laravel integration for `spatie/enum`. No longer needed.
- `myclabs/php-enum` — popular alternative with explicit constants. No longer needed.

If maintaining a pre-8.1 codebase, these packages still work. For new code, always use native enums.
