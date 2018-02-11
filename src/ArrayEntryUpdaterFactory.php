<?php

declare(strict_types=1);

namespace Stratadox\Proxy;

/**
 * Produces @see ArrayEntryUpdater instances.
 *
 * @package Stratadox\Hydrate
 * @author Stratadox
 */
class ArrayEntryUpdaterFactory implements ProducesOwnerUpdaters
{
    // @todo allow passing the closure
    public function makeUpdaterFor(
        $owner,
        string $ofTheProperty,
        $atPosition = null
    ) : UpdatesTheProxyOwner
    {
        return ArrayEntryUpdater::forThe($owner, $ofTheProperty, $atPosition);
    }
}
