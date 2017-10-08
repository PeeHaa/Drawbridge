<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge\Factories;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use function Netmosfera\Drawbridge\Source\createTrapClassSource;
use Netmosfera\Drawbridge\TrapSubject;
use ReflectionClass;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

function getTrapClass(
    TrapSubject $trapSubject,
    Bool $strictTypes
){
    static $trapClasses = [];

    $typeName = $trapSubject->getTypeString();

    $trapKey = $typeName . $strictTypes;

    if(isset($trapClasses[$trapKey]) === FALSE){

        $strictness = $strictTypes ? "Strict" : "Weak";

        do{
            $trapClassName = $typeName . $strictness . "Trap" . random_int(0, PHP_INT_MAX);
        } while(class_exists($trapClassName, TRUE));

        eval(createTrapClassSource($trapSubject, $strictTypes, $trapClassName));

        $trapClasses[$trapKey] = new ReflectionClass($trapClassName);
    }

    return $trapClasses[$trapKey];
}
