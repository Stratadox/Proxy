<?php declare(strict_types=1);

namespace Stratadox\Proxy;

/**
 * Proxying behaviour. Basic behaviour for easily creating a proxy class.
 *
 * @author Stratadox
 */
trait ProxyingWithoutConstructor
{
    /** @var null|static */
    private $instance;
    /** @var ProxyLoader */
    private $loader;
    /** @var array */
    private $knownData;

    /** @return static */
    private function _load()
    {
        if (null === $this->instance) {
            $this->instance = $this->loader->loadTheInstance($this->knownData);
        }
        return $this->instance;
    }
}
