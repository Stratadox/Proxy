<?php

namespace Stratadox\Proxy;

use function get_class;
use function gettype;
use InvalidArgumentException;
use function is_object;
use function sprintf;

class UnexpectedPropertyType extends InvalidArgumentException
{
    public static function expectedThe(
        string $interface,
        $object,
        $actual,
        string $property
    ) : self
    {
        return new self(sprintf(
            'Could not assign the value for `%s::%s`, got an `%s` instead of `%s`',
            get_class($object),
            $property,
            is_object($actual) ? get_class($actual) : gettype($actual),
            $interface
        ));
    }
}
