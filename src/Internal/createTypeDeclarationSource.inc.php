<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge\Internal;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use ReflectionType;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

/**
 * Returns the type declaration as `String` for the given `ReflectionType`.
 *
 * @internal
 *
 * @param           ReflectionType|NULL                     $RT                             `ReflectionType|NULL`
 * The `ReflectionType`, or `NULL` for `mixed`.
 *
 * @return          String                                                                  `String`
 * Returns the type declaration as `String` for the given `ReflectionType`.
 */
function createTypeDeclarationSource(?ReflectionType $RT): String{
    $source = "";
    if($RT !== NULL){
        $source .= $RT->allowsNull() ? "?" : "";
        $source .= $RT->isBuiltin() ? "" : "\\";
        $source .= (string)$RT;
    }
    return $source;
}
