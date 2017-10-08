<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge\Factories;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use Netmosfera\Drawbridge\TrapHandler;
use Netmosfera\Drawbridge\TrapSubject;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

function getTrapObject(
    TrapSubject $trapSubject,
    Bool $strictTypes,
    TrapHandler $handler
){
    $trapClass = getTrapClass($trapSubject, $strictTypes);
    return getTrapObjectFromTrapClass($trapClass, $handler);
}
