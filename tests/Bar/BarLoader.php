<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test\Bar;

use Stratadox\Proxy\Loader;

class BarLoader extends Loader
{
    protected function doLoad($forWhom, string $property, $position = null)
    {
        return new Bar($forWhom, $property);
    }
}
