<?php

declare(strict_types=1);

namespace Stratadox\Proxy;

use Stratadox\Deserializer\Deserializes;

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
        Deserializes $proxies,
        ProducesProxyLoaders $loaderFactory,
        ProducesOwnerUpdaters $updaterFactory
    ) {
        $this->makeProxy = $proxies;
        $this->loaderFactory = $loaderFactory;
        $this->updaterFactory = $updaterFactory;
    }

    public static function fromThis(
        Deserializes $proxies,
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
        return $this->makeProxy->from([
            'loader' => $loader
        ]);
    }
}
