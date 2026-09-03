# Commands — Common Tasks

Quick reference for generating and scaffolding code in this architecture.

> Note: These templates are derived from the patterns in the book, not directly extracted text.

---

## /new-domain {DomainName}

Creates the full folder structure for a new domain concept.

**Creates:**
```
Domain/{DomainName}/
├── Actions/
├── Commands/
├── Collections/
├── DataTransferObjects/
├── Events/
├── Exceptions/
├── Listeners/
├── Models/
├── QueryBuilders/
├── Rules/
└── States/
```

**Also creates matching test folder:**
```
tests/Domain/{DomainName}/
├── Actions/
├── Collections/
├── QueryBuilders/
└── States/
```

---

## /new-action {Domain} {ActionName}

Scaffolds a new action class.

**Template:**
```php
<?php

declare(strict_types=1);

namespace Domain\{Domain}\Actions;

class {ActionName}Action
{
    public function __construct(
        // inject dependencies here
    ) {}

    public function execute(/* {ActionName}Data $data */): mixed
    {
        // business logic here
    }
}
```

**Test template (Pest):**
```php
<?php

use Domain\{Domain}\Actions\{ActionName}Action;

it('does something', function () {
    // Setup

    // Execute
    $result = app({ActionName}Action::class)->execute();

    // Assert
    expect($result)->not()->toBeNull();
});
```

---

## /new-dto {Domain} {DtoName}

Scaffolds a new Data Object.

**Plain PHP Template:**
```php
<?php

declare(strict_types=1);

namespace Domain\{Domain}\DataTransferObjects;

class {DtoName}Data
{
    public function __construct(
        public readonly string $exampleField,
        // add typed properties here
    ) {}
}
```

**Laravel Data Template (recommended):**
```php
<?php

declare(strict_types=1);

namespace Domain\{Domain}\DataTransferObjects;

use Spatie\LaravelData\Data;

class {DtoName}Data extends Data
{
    public function __construct(
        public string $exampleField,
        // add typed properties here
    ) {}
}
```

---

## /new-state {Domain} {ModelName} {States...}

Scaffolds state classes for a model.

**Creates:**
- `{ModelName}State.php` (abstract base)
- One class per state name provided

**Abstract template:**
```php
<?php

namespace Domain\{Domain}\States;

use Domain\{Domain}\Models\{ModelName};

abstract class {ModelName}State
{
    public function __construct(
        protected {ModelName} $model,
    ) {}

    // abstract public function someMethod(): type;
}
```

**Concrete template:**
```php
<?php

namespace Domain\{Domain}\States;

class {StateName}{ModelName}State extends {ModelName}State
{
    // implement abstract methods
}
```

---

## /new-factory {ModelName}

Scaffolds an immutable test factory.

**Template:**
```php
<?php

namespace Tests\Factories;

use Domain\{Domain}\Models\{ModelName};

class {ModelName}Factory
{
    private static int $count = 0;

    private function __construct(
        // private configuration state here
    ) {}

    public static function new(): self
    {
        return new self();
    }

    public function create(array $extra = []): {ModelName}
    {
        return {ModelName}::create(array_merge([
            // default attributes here
        ], $extra));
    }
    
    // Example configurable state:
    // public function withSomeState(): self
    // {
    //     $clone = clone $this;
    //     $clone->someState = true;
    //     return $clone;
    // }
}
```

---

## /new-viewmodel {App} {Module} {ViewModelName}

Scaffolds a view model in the application layer.

**Template:**
```php
<?php

namespace App\{App}\{Module}\ViewModels;

use Illuminate\Contracts\Support\Arrayable;

class {ViewModelName}ViewModel implements Arrayable
{
    public function __construct(
        // inject dependencies here
    ) {}

    public function toArray(): array
    {
        return [
            // expose data to the view
        ];
    }
}
```

---

## /new-query {App} {Module} {QueryName}

Scaffolds an HTTP query builder.

**Template:**
```php
<?php

namespace App\{App}\{Module}\Queries;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class {QueryName}Query extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = {Model}::query()
            ->with([]);

        parent::__construct($query, $request);

        $this
            ->allowedFilters([])
            ->allowedSorts([]);
    }
}
```

---

## Checklist: Adding a New Feature

When a new business requirement arrives:

- [ ] Identify which domain(s) it touches
- [ ] Create/update the data object for the input data
- [ ] Write the action(s) representing the operation
- [ ] Update/create model states if state changes are involved
- [ ] Create test factories for new models/data objects
- [ ] Write action tests (setup → execute → assert)
- [ ] Wire up in the application layer (controller/job/command)
- [ ] Add view model if the UI needs shaped data
- [ ] Add HTTP query builder if it's a list view with filters
