<?php

declare(strict_types=1);

namespace Stratadox\Proxy;

use function is_null as weDidNotYetLoad;

/**
 * Lazily loads proxy targets.
 *
 * @author Stratadox
 * @package Stratadox/Hydrate
 */
trait Proxying
{
    /** @var LoadsProxiedObjects */
    private $loader;

    /** @var object|null */
    private $instance;

    /** @return self */
    public function __load()
    {
        if (weDidNotYetLoad($this->instance)) {
            /** @var Proxy $this */
            $this->instance = $this->loader->loadTheInstance();
        }
        return $this->instance;
    }
}
