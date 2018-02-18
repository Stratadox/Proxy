<?php

namespace Stratadox\Proxy;

use function get_class as theClassOf;
use function gettype as orTheTypeOf;
use InvalidArgumentException;
use function is_object as isItAnObject;
use function sprintf as withMessage;

final class UnexpectedPropertyType extends InvalidArgumentException
{
    public static function expectedThe(
        string $interface,
        $theOwningObject,
        $whatWeGot,
        string $property
    ): UnexpectedPropertyType {
        return new UnexpectedPropertyType(withMessage(
            'Could not assign the value for `%s::%s`, got an `%s` instead of `%s`',
            theClassOf($theOwningObject),
            $property,
            isItAnObject($whatWeGot)? theClassOf($whatWeGot) : orTheTypeOf($whatWeGot),
            $interface
        ));
    }
}
