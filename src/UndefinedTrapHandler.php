<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use Closure;
use Error;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

/**
 * @TODOC
 */
class UndefinedTrapHandler implements TrapHandler
{
    /** @inheritDoc */
    function handleGet($object, String $member){
        throw new Error("Undefined get handler");
    }

    /** @inheritDoc */
    function handleSet($object, String $member, $content){
        throw new Error("Undefined set handler");
    }

    /** @inheritDoc */
    function handleCall(Closure $closure, Array $arguments){
        throw new Error("Undefined call handler");
    }
}
