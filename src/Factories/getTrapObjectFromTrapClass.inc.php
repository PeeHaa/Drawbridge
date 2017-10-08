<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge\Factories;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use Netmosfera\Drawbridge\TrapHandler;
use ReflectionClass;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

function getTrapObjectFromTrapClass(ReflectionClass $RC, TrapHandler $handler){
    $object = $RC->newInstanceWithoutConstructor();

    // Un-declaring all fields is required for allowing `__get` and `__set` to capture
    // the interactions on fields. This is the only solution available.
    foreach($RC->getProperties() as $property){
        $declaringClass = $property->getDeclaringClass();
        $propertyName = $property->getName();
        (function() use($propertyName){
            unset($this->{$propertyName});
        })->bindTo($object, $declaringClass);
    }

    $object->NETMOSFERA_DRAWBRIDGE_HANDLER = $handler;

    return $object;
}
