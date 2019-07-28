<?php declare(strict_types=1);

namespace Stratadox\Proxy;

trait Proxying
{
    /** @var null|static */
    private $instance;
    private $loader;

    public function __construct(ProxyLoadingAdapter $loader)
    {
        $this->loader = $loader;
    }

    /** @return static */
    private function _load()
    {
        if (null === $this->instance) {
            /** @var Proxying|Proxy $this */
            $this->instance = $this->loader->load($this);
        }
        return $this->instance;
    }
}
