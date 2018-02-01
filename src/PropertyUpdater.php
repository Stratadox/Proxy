<?php

declare(strict_types=1);

namespace Stratadox\Proxy;

use Closure;
use Stratadox\Proxy\UpdatesTheProxyOwner;

/**
 * Updates a property with the newly loaded value.
 *
 * @package Stratadox\Hydrate
 * @author Stratadox
 */
class PropertyUpdater implements UpdatesTheProxyOwner
{
    private $owner;
    private $propertyShouldReference;
    private $setter;

    public function __construct(
        $theOwner,
        string $theProperty,
        Closure $setter = null
    ) {
        $this->owner = $theOwner;
        $this->propertyShouldReference = $theProperty;
        $this->setter = $setter ?: function (string $property, $value) : void
        {
            $this->$property = $value;
        };
    }

    public static function for(
        $theOwner,
        string $ofTheProperty,
        Closure $setter = null
    ) : UpdatesTheProxyOwner
    {
        return new static($theOwner, $ofTheProperty, $setter);
    }

    public function updateWith($theLoadedInstance) : void
    {
        $this->setter->call($this->owner,
            $this->propertyShouldReference,
            $theLoadedInstance
        );
    }
}
