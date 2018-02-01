<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test\Foo;

use Stratadox\Proxy\Loader;

class FooLoader extends Loader
{
    protected function doLoad($forWhom, string $property, $position = null)
    {
        return new Foo;
    }
}
