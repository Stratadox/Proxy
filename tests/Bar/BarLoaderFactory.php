<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test\Bar;

use Stratadox\Proxy\LoadsProxiedObjects;
use Stratadox\Proxy\ProducesProxyLoaders;

class BarLoaderFactory implements ProducesProxyLoaders
{
    public function makeLoaderFor(
        $theOwner,
        string $ofTheProperty,
        $atPosition = null
    ) : LoadsProxiedObjects
    {
        return new BarLoader($theOwner, $ofTheProperty);
    }
}
