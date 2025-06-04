
# PHPStan Utilities

This is a collection of PHPStan utilities you can use to transform types.

## Installation

```bash
composer require vixducis/phpstan-utilities
```

Afterwards, add the following section to your `phpstan.neon` configuration file:

```
includes:
- vendor/vixducis/phpstan-utilities/extension.neon
```

## Utilities

This package provides several type transformation utilities for use with PHPStan. Each utility can be used as a generic type in your PHPDoc or PHPStan configuration.

### ArrayValues

Sometimes, you'll have a template type that contains a template, but you still want to extract the values from it.

**Usage:**
```php
/** @var ArrayValues<T> */
```
This utility extracts the value types from an array type `T`. If `T` is an array, it returns the type of its values. Otherwise, it returns an error type.

This differs from `value-of`: `value-of<array{a:int,b:string}>` will return `int|string`. `ArrayValues<array{a:int,b:string}>` will return `array{int,string}`.

---

### UnwrapSingletonArray

This utility unwraps a singleton array type, i.e., if the type is an array containing exactly one element, it yields both the original array type and the value type as a union. Otherwise, it returns the original type.

**Usage:**
```php
/** @var UnwrapSingletonArray<T> */
```
- If `T` is an array of exactly one element, returns `T|V` (where `V` is the value type).
- Otherwise, returns `T`.

---

### UnionToIntersection

This utility converts a union type into an intersection type.

**Usage:**
```php
/** @var UnionToIntersection<T> */
```
If `T` is a union type (e.g., `A|B`), `UnionToIntersection<T>` produces an intersection (e.g., `A&B`). If `T` is not a union, returns an error type.

