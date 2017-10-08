# Drawbridge

Delegates all interactions performed on one or more "trap" objects to the same unified
"handler" interface. Can be used to create proxies, facades, adapters, decorators, any other
kind of wrapper, AOP, logging, access control.

## Composer Installation

```
composer require netmosfera/drawbridge
```
## Design description:

### The traps:
This library consists of two main group of functions; one is meant to create trap-objects,
while the other is specific to `Closure`s.

Creating trap-objects requires the creation of trap-classes first. These trap-classes have
no semantic meaning, which instead resides in the original type that they are meant to
emulate; they exist for the sole purpose of allowing to create trap-objects. It is a good
idea to avoid referencing these trap-classes anywhere except when required by this
library's own functionality.
 
A trap-class implements the same interface as the emulated type. All interactions (get, set,
call) performed on a trap-object are delegated to a handler (`TrapHandler`).

Trap-classes cannot be instantiated using `new`. This is by design, because for this
library's original purpose it was necessary to have the trap's `__construct` matching the
emulated type's one. This implies that the handler must be installed in the trap-object
using `Reflection`. The function that simplifies this operation is
`createTrapObjectFromTrapClass()`. This could be improved in future.

Trap-`Closure`s are fundamentally just `Closure`s that delegate to a `TrapHandler`, but
this library allows to create trap-`Closure`s that match the signature (with types and
everything) of an existing function.

### The trap-handler:

The `TrapHandler` is an object that handles the `get`, `set` and `call` operations
respectively with the methods `handleGet`, `handleSet` and `handleCall`. A trap handler can
be the handler of a single trap-object or many trap-objects: it's up to the user. Handlers
can be obviously stacked one into another and fulfill requests using the strategy pattern.

## Example:

```php
<?php

use Netmosfera\Drawbridge\TrapHandler;
use function Netmosfera\Drawbridge\Factories\getTrapClosureWithTypesFactory;

$myHandler = new class() implements TrapHandler{
    /** @inheritDoc */
    function handleGet($object, String $member){
        return [$object, "foo bar baz", $member];
    }
    
    /** @inheritDoc */
    function handleSet($object, String $member, $content){
        return [$object, $member, "foo bar baz", $content];
    }
    
    /** @inheritDoc */
    function handleCall(Closure $closure, Array $arguments){
        return [$closure, "foo bar baz", $arguments];
    }
};


// Example call:
$signature = function(int $a, float $b): array{};
$reflectionFunction = new ReflectionFunction($signature);
$closureFactory = getTrapClosureWithTypesFactory($reflectionFunction)
$closure = $closureFactory($myHandler);
assert($closure(1, 2, 3) === [$closure, "foo bar baz", [1, 2, 3]]);
```

## Caching the generated code:

Creating traps can have some significant overhead because of the required `Reflection`
operations. However, this library includes all the functions to enable the user to cache
the generated source and execute it like a static `.php` file.

For example, `Closure`s can be cached using `getTrapClosureWithTypesFromCache()`:

```php
<?php

use function Netmosfera\Drawbridge\Factories\getTrapClosureWithTypesFactoryFromCache;
use Netmosfera\Drawbridge\UndefinedTrapHandler;

$signature = function(int $a, float $b): string{};

$reflectionFunction = new ReflectionFunction($signature);

$closureFactory = getTrapClosureWithTypesFactoryFromCache(
    $reflectionFunction,
    __DIR__ . "/my_closure_factory.php"
);

$myHandler = new class() extends UndefinedTrapHandler{
    function handleCall(Closure $closure, Array $arguments){
        return "call " . array_sum($arguments);
    }
};

$closure = $closureFactory($myHandler);

assert($closure(1, 2, 3) === "call 6");
```

Alternatively, the user can implement their own caching using the provided
`createTrapClosureWithTypesFactorySource()`. 

Similarly, the source of other classes' objects (i.e. not `Closure`s) can be cached using a
combination of `createTrapClassSource()` and `getTrapObjectFromTrapClass()`, like in the
following example:

```php
<?php

use function Netmosfera\Drawbridge\Factories\getTrapClassFromCache;
use function Netmosfera\Drawbridge\Factories\getTrapObjectFromTrapClass;
use Netmosfera\Drawbridge\TrapSubject;

interface MyType{ function hello(); }
$trapSubject = new TrapSubject(MyType::CLASS);
$reflectionClass = getTrapClassFromCache($trapSubject, __DIR__);
$object = getTrapObjectFromTrapClass($reflectionClass, $myHandler);
```
