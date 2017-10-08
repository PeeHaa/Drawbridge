<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge\Factories;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use function Netmosfera\Drawbridge\Source\createTrapClassSource;
use Netmosfera\Drawbridge\TrapSubject;
use ReflectionClass;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

function getTrapClassFromCache(
    TrapSubject $subject,
    String $cacheDirectoryPath
): ReflectionClass{
    static $trapClasses = [];
    $typeName = $subject->getTypeString();
    if(isset($trapClasses[$typeName]) === FALSE){
        $destinationTrapClass = $typeName . "NetmosferaDrawbridgeTrap";
        $destinationTrapClassFile = $cacheDirectoryPath . "/" . sha1($destinationTrapClass) . ".php";
        if(file_exists($destinationTrapClassFile) === FALSE){
            $source = createTrapClassSource($subject, TRUE, $destinationTrapClass);
            file_put_contents($destinationTrapClassFile, "<?php " . $source);
        }
        require($destinationTrapClassFile);
        $trapClasses[$typeName] = new ReflectionClass($destinationTrapClass);
    }
    return $trapClasses[$typeName];
}
