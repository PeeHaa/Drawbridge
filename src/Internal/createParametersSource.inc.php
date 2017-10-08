<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge\Internal;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use ReflectionParameter;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

/**
 * @TODOC
 *
 * @internal
 *
 * @param       Iterable|ReflectionParameter[]              $RPs                            `Iterable<Mixed, ReflectionParameter>`
 * @TODOC
 *
 * @return      String                                                                      `String`
 * @TODOC
 */
function createParametersSource(Iterable $RPs): String{
    $source = [];
    foreach($RPs as $index => $RP){
        $source[$index]  = $type = createTypeDeclarationSource($RP->getType());
        $source[$index] .= $type === "" ? "" : " ";
        $source[$index] .= $RP->isVariadic() ? "..." : "";
        $source[$index] .= "\$p" . $index;
        if($RP->isDefaultValueAvailable()){
            $source[$index] .= " = ";
            $source[$index] .= $RP->getDefaultValueConstantName()
                ? $RP->getDefaultValueConstantName()
                : var_export($RP->getDefaultValue(), TRUE);
        }
    }
    return implode(", ", $source);
}
