<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge\Internal;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

/**
 * Splits a FQN in namespace and class.
 *
 * @internal
 *
 * @param       String                                      $qualifiedName                  `String`
 * @TODOC
 *
 * @return      String[]                                                                    `Array`
 * @TODOC
 */
function splitFQNIntoNSAndShortName(String $qualifiedName): Array{
    preg_match('/(.*?)\\\?([^\\\]*)$/', trim($qualifiedName, "\\"), $results);
    return array_slice($results, 1);
}
