<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge\Factories;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use function file_exists;
use function Netmosfera\Drawbridge\Source\createTrapClosureWithTypesFactorySource;
use ReflectionFunctionAbstract;
use Closure;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

function getTrapClosureWithTypesFactoryFromCache(
    ReflectionFunctionAbstract $RF,
    String $cacheFile
): Closure{
    if(file_exists($cacheFile) === FALSE){
        $source = createTrapClosureWithTypesFactorySource($RF);
        file_put_contents($cacheFile, "<?php " . $source);
    }
    return require($cacheFile);
}
