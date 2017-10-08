<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use Closure;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

/**
 * @TODOC
 */
interface TrapHandler
{
    /**
     * @TODOC
     *
     * @param       Mixed                                   $object                         `Mixed`
     * @TODOC
     *
     * @param       String                                  $member                         `String`
     * @TODOC
     *
     * @return      Mixed                                                                   `Mixed`
     * @TODOC
     */
    function handleGet($object, String $member);

    /**
     * @TODOC
     *
     * @param       Mixed                                   $object                         `Mixed`
     * @TODOC
     *
     * @param       String                                  $member                         `String`
     * @TODOC
     *
     * @param       Mixed                                   $content                        `Mixed`
     * @TODOC
     *
     * @return      Mixed                                                                   `Mixed`
     * @TODOC
     */
    function handleSet($object, String $member, $content);

    /**
     * @TODOC
     *
     * @param       Closure                                 $closure                        `Closure`
     * @TODOC
     *
     * @param       Mixed[]                                 $arguments                      `Array<Mixed, Mixed>`
     * @TODOC
     *
     * @return      Mixed                                                                   `Mixed`
     * @TODOC
     */
    function handleCall(Closure $closure, Array $arguments);
}
