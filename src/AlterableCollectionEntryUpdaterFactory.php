<?php

declare(strict_types=1);

namespace Stratadox\Proxy;

/**
 * Produces @see AlterableCollectionEntryUpdater instances.
 *
 * @package Stratadox\Hydrate
 * @author  Stratadox
 */
final class AlterableCollectionEntryUpdaterFactory implements ProducesOwnerUpdaters
{
    // @todo allow passing the closure
    public function makeUpdaterFor(
        $owner,
        string $ofTheProperty,
        $atPosition = null
    ): UpdatesTheProxyOwner {
        return AlterableCollectionEntryUpdater::forThe($owner, $ofTheProperty, $atPosition);
    }
}
