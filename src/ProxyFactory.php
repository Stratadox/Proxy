<?php

declare(strict_types=1);

namespace Stratadox\Proxy;

use Stratadox\Hydrator\Hydrates;

/**
 * Instantiates proxy objects, providing them with a loader.
 *
 * @author  Stratadox
 * @package Stratadox/Hydrate
 */
final class ProxyFactory implements ProducesProxies
{
    private $makeProxy;
    private $loaderFactory;
    private $updaterFactory;

    private function __construct(
        Hydrates $proxies,
        ProducesProxyLoaders $loaderFactory,
        ProducesOwnerUpdaters $updaterFactory
    ) {
        $this->makeProxy = $proxies;
        $this->loaderFactory = $loaderFactory;
        $this->updaterFactory = $updaterFactory;
    }

    public static function fromThis(
        Hydrates $proxies,
        ProducesProxyLoaders $loaderFactory,
        ProducesOwnerUpdaters $updaterFactory
    ): ProxyFactory {
        return new static($proxies, $loaderFactory, $updaterFactory);
    }

    /** @inheritdoc */
    public function createFor(
        $theOwner,
        string $ofTheProperty,
        $atPosition = null
    ): Proxy {
        $loader = $this->loaderFactory->makeLoaderFor($theOwner, $ofTheProperty, $atPosition);
        $loader->attach(
            $this->updaterFactory->makeUpdaterFor($theOwner, $ofTheProperty, $atPosition)
        );
        return $this->makeProxy->fromArray([
            'loader' => $loader
        ]);
    }
}
