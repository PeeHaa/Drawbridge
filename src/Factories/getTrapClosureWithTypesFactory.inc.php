<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge\Factories;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use function Netmosfera\Drawbridge\Source\createTrapClosureWithTypesFactorySource;
use ReflectionFunctionAbstract;
use Closure;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

function getTrapClosureWithTypesFactory(
    ReflectionFunctionAbstract $RF
): Closure{
    return eval(createTrapClosureWithTypesFactorySource($RF));
}
