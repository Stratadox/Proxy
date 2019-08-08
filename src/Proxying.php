<?php declare(strict_types=1);

namespace Stratadox\Proxy;

/**
 * Proxying behaviour. Basic behaviour for easily creating a proxy class.
 *
 * @author Stratadox
 */
trait Proxying
{
    /** @var null|static */
    private $instance;
    private $loader;
    private $knownData;

    public function __construct(ProxyLoader $loader, array $knownData)
    {
        $this->loader = $loader;
        $this->knownData = $knownData;
    }

    /** @return static */
    private function _load()
    {
        if (null === $this->instance) {
            $this->instance = $this->loader->loadTheInstance($this->knownData);
        }
        return $this->instance;
    }
}
