<?php

declare(strict_types=1);

namespace Stratadox\Proxy;

use Stratadox\Hydrator\Hydrates;
use Stratadox\Hydrator\ObjectHydrator;

/**
 * Updates a property with the newly loaded value.
 *
 * @package Stratadox\Hydrate
 * @author  Stratadox
 */
final class PropertyUpdater implements UpdatesTheProxyOwner
{
    private $owner;
    private $propertyShouldReference;
    private $hydrator;

    public function __construct(
        $theOwner,
        string $theProperty,
        Hydrates $hydrator
    ) {
        $this->owner = $theOwner;
        $this->propertyShouldReference = $theProperty;
        $this->hydrator = $hydrator;
    }

    public static function forThe(
        $owner,
        string $ofTheProperty,
        Hydrates $setter = null
    ): UpdatesTheProxyOwner {
        return new self(
            $owner,
            $ofTheProperty,
            $setter ?: ObjectHydrator::default()
        );
    }

    /** @inheritdoc */
    public function updateWith($theLoadedInstance): void
    {
        $this->hydrator->writeTo(
            $this->owner,
            [$this->propertyShouldReference => $theLoadedInstance]
        );
    }
}
