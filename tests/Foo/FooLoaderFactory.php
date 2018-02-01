<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test\Foo;

use Stratadox\Proxy\LoadsProxiedObjects;
use Stratadox\Proxy\ProducesProxyLoaders;

class FooLoaderFactory implements ProducesProxyLoaders
{
    public function makeLoaderFor(
        $theOwner,
        string $ofTheProperty,
        $atPosition = null
    ) : LoadsProxiedObjects
    {
        return new FooLoader($theOwner, $ofTheProperty);
    }
}
