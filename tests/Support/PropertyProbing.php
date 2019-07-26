<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Support;

use ReflectionProperty;

trait PropertyProbing
{
    protected function valueOf(string $class, object $object, string $property)
    {
        $reflectionProperty = new ReflectionProperty($class, $property);
        $reflectionProperty->setAccessible(true);
        return $reflectionProperty->getValue($object);
    }
}
