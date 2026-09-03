# Data Objects (DTOs)

Data objects make data a first-class citizen of the codebase. They are the entry point for all external data entering the domain.

> **Terminology:** The book uses "data objects" and "DTOs" (data transfer objects) interchangeably. Both refer to the same pattern.

---

## Purpose

Wrap unstructured data (arrays, request payloads) in strongly typed, predictable objects. This:

- Eliminates "array of unknown stuff" problems
- Enables IDE autocompletion and static analysis
- Reduces cognitive load — you always know what data you're working with
- Catches type errors at analysis time, not runtime

---

## The Problem Data Objects Solve

```php
// BAD — what is in $validated? You don't know without digging.
function store(CustomerRequest $request, Customer $customer)
{
    $validated = $request->validated();
    $customer->name = $validated['name'];     // maybe?
    $customer->email = $validated['email'];   // maybe?
}

// GOOD — self-documenting, statically analysable
function store(CustomerRequest $request, Customer $customer)
{
    $data = CustomerData::fromRequest($request);
    $customer->name = $data->name;       // IDE knows this exists
    $customer->email = $data->email;     // IDE knows the type
    $customer->birth_date = $data->birth_date; // Carbon, guaranteed
}
```

---

## Plain PHP Data Object (PHP 8+)

The simplest approach — a plain class with constructor property promotion:

```php
class CustomerData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly Carbon $birth_date,
    ) {}
}
```

Construction from a request using the spread operator:

```php
class CustomerController
{
    public function update(UpdateCustomerRequest $request)
    {
        $customerData = new CustomerData(...$request->validated());

        // ... do something with customerData
    }
}
```

This works for simple cases where all properties are scalar types. It breaks down when you have object properties (like `Carbon $birth_date`) because the request returns a string, not a Carbon instance.

---

## Construction Approaches for Complex Data Objects

### Option A: Dedicated factory in the application layer (theoretically correct)

```php
class CustomerDataFactory
{
    public function fromRequest(CustomerRequest $request): CustomerData
    {
        return new CustomerData(
            name: $request->get('name'),
            email: $request->get('email'),
            birth_date: Carbon::make($request->get('birth_date')),
        );
    }
}
```

Keeps the domain clean. The factory lives in the application layer.

### Option B: Static constructor on the data object (pragmatic)

```php
$data = CustomerData::fromRequest($request);
```

Mixes application knowledge into the domain, but keeps construction logic close to the data class.

---

## Using spatie/laravel-data (Recommended)

At Spatie, the `spatie/laravel-data` package is the primary way to create and work with data objects in Laravel. It extends data objects with powerful capabilities.

```php
use Spatie\LaravelData\Data;

class CustomerData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public Carbon $birth_date,
    ) {}
}
```

### Data Objects as Form Requests

With Laravel Data, data objects can **replace form requests** entirely. Inject the data object directly in the controller:

```php
class CustomerController
{
    public function update(CustomerData $customerData)
    {
        // $customerData is already validated and constructed
        // The controller method only runs if construction succeeds
    }
}
```

Laravel Data automatically handles type conversion (e.g., string → Carbon).

### Validation via Attributes

Add validation rules directly on properties:

```php
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Rule;

class CustomerData extends Data
{
    public function __construct(
        public string $name,
        #[Rule('email')]
        public string $email,
        public Carbon $birth_date,
    ) {}
}
```

### Additional Capabilities

- **API Resources:** Data objects can serve as API resources (replacing `JsonResource`)
- **TypeScript generation:** Can be converted to TypeScript type definitions
- **Nesting:** Data objects can contain other data objects
- **Collections:** Typed collections of data objects

See the [Laravel Data documentation](https://spatie.be/docs/laravel-data) for the full API.

---

## What NOT to Put in Data Objects

- Business logic
- Calculations
- Database queries
- Side effects of any kind

Data objects are pure data containers. Their only job is structured representation of data.

---

## Testing Data Objects

Data objects with only typed properties need no tests — the type system IS the test.

Test ONLY if you have a `fromRequest()` or similar static constructor:

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

## Relevant Packages

- `spatie/laravel-data` — **Primary recommendation.** Data objects with validation, form request replacement, API resource capability, TypeScript generation.
- `spatie/data-transfer-object` — Legacy DTO package. Superseded by `spatie/laravel-data` for new projects.
