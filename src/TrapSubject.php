<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use ReflectionClass;
use ReflectionException;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

/**
 * @TODOC
 */
class TrapSubject
{
    /**
     * @TODOC
     *
     * @var         String                                                                  `String`
     */
    private $type;

    /**
     * @param       String                                  $type                           `String`
     * @TODOC
     *
     * @throws      CannotEmulateType                                                       `CannotDouble`
     * @TODOC
     */
    function __construct(String $type){
        try{
            $RC = new ReflectionClass($type);
        }catch(ReflectionException $e){
            throw new CannotEmulateType(sprintf(
                "Cannot find type `%s`",
                (String)$type
            ));
        }

        if($RC->isTrait()){
            throw new CannotEmulateType(sprintf(
                "Cannot find type `%s`",
                (String)$type
            ));
        }

        if($RC->isFinal()){
            throw new CannotEmulateType(sprintf(
                "Cannot create a trap object for `final class` `%s`",
                (String)$type
            ));
        }

        foreach($RC->getMethods() as $RM){
            if(!$RM->isPrivate() && $RM->isFinal()){
                throw new CannotEmulateType(sprintf(
                    "Cannot create a trap object for a class containing `final` member `%s::%s`",
                    (String)$RC->getName(),
                    (String)$RM->getName()
                ));
            }
        }

        $this->type = $type;
    }

    /**
     * @TODOC
     *
     * @return      String                                                                  `String`
     * @TODOC
     */
    function getTypeString(): String{
        return $this->type;
    }
}
