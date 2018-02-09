<?php

declare(strict_types=1);

namespace Stratadox\Proxy;

/**
 * Produces @see AlterableCollectionEntryUpdater instances.
 *
 * @package Stratadox\Hydrate
 * @author Stratadox
 */
class AlterableCollectionEntryUpdaterFactory implements ProducesOwnerUpdaters
{
    // @todo allow passing the closure
    public function makeUpdaterFor(
        $theOwner,
        string $ofTheProperty,
        $atPosition = null
    ) : UpdatesTheProxyOwner
    {
        return AlterableCollectionEntryUpdater::for($theOwner, $ofTheProperty, $atPosition);
    }
}
