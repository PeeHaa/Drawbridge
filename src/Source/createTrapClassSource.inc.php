<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge\Source;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use function Netmosfera\Drawbridge\Internal\createTypeDeclarationSource;
use function Netmosfera\Drawbridge\Internal\createParametersSource;
use function Netmosfera\Drawbridge\Internal\splitFQNIntoNSAndShortName;
use Netmosfera\Drawbridge\TrapSubject;
use ReflectionClass;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

/**
 * Creates the source of the trap-class.
 *
 * Note that once evaluated this class' objects can only be instantiated using
 * {@see getTrapObjectFromTrapClass()}.
 *
 * Also note that the returned source code does not include `<?php `, which must be
 * prepended to the source in case it is desired to run it from a file.
 *
 * @param           TrapSubject                             $subject                        `TrapSubject`
 * @TODOC
 *
 * @param           Bool                                    $strictTypes                    `Bool`
 * @TODOC
 *
 * @param           String                                  $destinationClass               `String`
 * @TODOC
 *
 * @return          String                                                                  `String`
 * @TODOC
 */
function createTrapClassSource(
    TrapSubject $subject,
    Bool $strictTypes,
    String $destinationClass
): String{
    $typeName = $subject->getTypeString();

    $RC = new ReflectionClass($typeName);

    $handlerFieldName = "NETMOSFERA_DRAWBRIDGE_HANDLER";

    [$trapNamespaceName, $trapShortName] = splitFQNIntoNSAndShortName($destinationClass);

    $source  = "";

    $source .= $strictTypes ? "declare(strict_types = 1);\n" : "";

    $source .= "namespace " . $trapNamespaceName . "{\n";

    $source .= "use function PHPToolBucket\\Bucket\\arguments;\n";

    $source .= "class " . $trapShortName . " ";

    $source .= $RC->isInterface() ? "implements " : "extends ";

    $source .= "\\" . $typeName . "{\n";

    $source .= "private \$" . $handlerFieldName . ";\n";

    $source .= "function __destruct(){}\n";

    $source .= "function __get(\$memberName)";
    $source .= "{ return \$this->" . $handlerFieldName . "->handleGet(\$this, \$memberName); }\n";

    $source .= "function __set(\$memberName, \$content)";
    $source .= "{ return \$this->" . $handlerFieldName . "->handleSet(\$this, \$memberName); }\n";

    $excludeMethods = ["__destruct", "__get", "__set"];
    foreach($RC->getMethods() as $RM){

        // Private methods are included, but only those actually private to `$typeName`.
        // The second part of the check is necessary because Reflection lists also
        // private methods from super classes:
        if($RM->isPrivate() && $RM->getDeclaringClass()->getName() !== $typeName){ continue; }

        // Static methods are also excluded:
        if($RM->isStatic()){ continue; }

        // @TODOC
        if(in_array(strtolower($RM->getName()), $excludeMethods)){ continue; }

        $source .= "function " . $RM->getName();

        $source .= "(" . createParametersSource($RM->getParameters()) . ")";

        $source .= $RM->getReturnType() === NULL ? "" : ": " . createTypeDeclarationSource($RM->getReturnType());

        $source .= "{ return \$this->" . $handlerFieldName . "->handleGet(\$this, \"" . $RM->getName() . "\")(...arguments()); }\n";
    }

    $source .= "}\n";

    $source .= "}\n";

    return $source;
}
