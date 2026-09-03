# PHP Type System — Context & Theory

Understanding PHP's type system is foundational to understanding why data objects and strong typing matter in large codebases.

---

## Weak vs. Strong Types

**Weak (PHP):** Variables can change type after assignment. Type coercion happens silently.

```php
$a = 'test'; // string
$a = 1;      // now int — PHP allows this

function find(int $id): Model {}

$id = '1';
find($id); // '1' is coerced to 1 — no error
```

**Strong:** Once typed, a variable cannot change type. A whole class of bugs becomes impossible.

---

## Static vs. Dynamic Types

**Dynamic (PHP):** Type checks happen at runtime. A type error crashes the running program.

**Static:** Type checks happen before execution (at compile time). Errors are caught before the program runs.

PHP is dynamic. But tools like PHPStan, Phan, and Psalm apply static analysis to PHP — giving you the benefits of static typing without changing the language.

---

## The Guarantee of Strong + Static Types

> "It's mathematically provable that if a strongly typed program compiles, it's impossible for that program to have a range of bugs which would be able to exist in weakly typed languages."

This is why we use data objects. They are as close to strong typing as PHP allows. Combined with PHPStan/Psalm, they eliminate whole categories of runtime bugs.

---

## PHP's Type Improvements Over Time

| Version | What Changed |
|---|---|
| PHP 7.0 | Type declarations for parameters and return types |
| PHP 7.4 | Typed class properties |
| PHP 8.0 | Named arguments, union types, match expression, constructor property promotion |
| PHP 8.1 | Native enums, readonly properties, fibers |
| PHP 8.2 | Readonly classes, disjunctive normal form types |

**Impact on this architecture:**

- PHP 8.0: Constructor promotion → clean data object construction, `match` for enum methods
- PHP 8.1: Native enums → drop `spatie/enum`, readonly properties for data objects
- PHP 8.2: Readonly classes → entire data object classes can be readonly

---

## Strict Types Declaration

```php
declare(strict_types=1);
```

Prevents type coercion at function call sites:

```php
declare(strict_types=1);

function find(int $id): Model {}

find('1'); // TypeError — string not accepted
find(1);   // Fine
```

But strict types don't make variables immutable:

```php
function find(int $id): Model
{
    $id = '' . $id; // Now a string — PHP allows this inside the function
}
```

This is why typed class properties (data objects) are better than just strict_types — they enforce the type on the property itself throughout the object's life.

---

## Static Analysis Tools

Add these to your project:

| Tool | Package | Config |
|---|---|---|
| PHPStan | `phpstan/phpstan` | `phpstan.neon` |
| Larastan | `nunomaduro/larastan` | Laravel-aware PHPStan wrapper |
| Psalm | `vimeo/psalm` | `psalm.xml` |

These tools find type errors, null dereferences, and unreachable code before you run the application. In large teams, they pay for themselves immediately.

---

## The Practical Payoff

Without strong types:
- You must read source code or dump variables to know what data you're working with
- A colleague's code is a black box unless documented
- IDEs can't autocomplete or validate your code

With strong types (data objects + static analysis):
- Your IDE knows every property's type
- Passing the wrong data is caught before deployment
- New developers can read the code and understand the data shapes immediately

> "You have to take every opportunity you can to reduce cognitive load. You don't want developers having to start debugging their code every time they want to know what exactly is in a variable."
