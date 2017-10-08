<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge\Source;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use function Netmosfera\Drawbridge\Internal\createParametersSource;
use function Netmosfera\Drawbridge\Internal\createTypeDeclarationSource;
use Netmosfera\Drawbridge\TrapHandler;
use ReflectionFunctionAbstract;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

/**
 * @TODOC
 *
 * @param           ReflectionFunctionAbstract              $RF                             `ReflectionFunctionAbstract`
 * @TODOC
 *
 * @return          String                                                                  `String`
 * @TODOC
 */
function createTrapClosureWithTypesFactorySource(ReflectionFunctionAbstract $RF): String{
    $source  = 'return function(\\' . TrapHandler::CLASS . ' $handler){ ';

    $source .= 'return $self = function use(&$self, $handler) ';

    $source .= '(' . createParametersSource($RF->getParameters()) . ')';

    $source .= $RF->getReturnType() === NULL ? "" : ": " . createTypeDeclarationSource($RF->getReturnType());

    $source .= '{ return $handler->handleExec($self, arguments()); } ';

    $source .= '};';

    return $source;
}
