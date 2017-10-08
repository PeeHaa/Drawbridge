<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge\Factories;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use Closure;
use Netmosfera\Drawbridge\TrapHandler;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

function getTrapClosureWithNoTypes(TrapHandler $handler): Closure{
    return $self = function(...$arguments) use(&$self, $handler){
        return $handler->handleCall(...$arguments);
    };
}
