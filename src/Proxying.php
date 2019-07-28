<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use LogicException;

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
            try {
                /** @var Proxying|Proxy $this */
                $this->instance = $this->loader->load($this);
            } catch (ProxyLoadingFailure $e) {
                throw new LogicException(
                    'Proxy configuration error: ' . $e->getMessage(),
                    $e->getCode(),
                    $e
                );
            }
        }
        return $this->instance;
    }
}
