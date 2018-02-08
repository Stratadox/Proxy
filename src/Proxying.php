<?php

declare(strict_types=1);

namespace Stratadox\Proxy;

use function is_null;

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
        if (is_null($this->instance)) {
            /** @var Proxy $this */
            $this->instance = $this->loader->loadTheInstance();
        }
        return $this->instance;
    }
}
