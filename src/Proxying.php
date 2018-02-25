<?php

declare(strict_types=1);

namespace Stratadox\Proxy;

use function get_class as classOf;
use function is_null as weDidNotYetLoad;
use LogicException;
use function sprintf as withMessage;

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
        if (!$this->loader instanceof LoadsProxiedObjects) {
            throw new LogicException(withMessage(
                'Cannot load the proxy without a loader. Proxy class: %s',
                classOf($this)
            ));
        }
        if (weDidNotYetLoad($this->instance)) {
            /** @var Proxy $this */
            $this->instance = $this->loader->loadTheInstance();
        }
        return $this->instance;
    }
}
