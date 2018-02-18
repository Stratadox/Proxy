<?php

declare(strict_types=1);

namespace Stratadox\Proxy;

/**
 * Lazily loads proxied objects when they are called upon.
 *
 * @package Stratadox\Hydrate
 * @author Stratadox
 */
abstract class Loader implements LoadsProxiedObjects
{
    /** @var ObservesProxyLoading[] */
    private $observers = [];

    /** @var mixed|object */
    private $forWhom;

    /** @var string */
    private $property;

    /** @var string|null */
    private $position;

    /**
     * @param object          $forWhom  The owner of the property.
     * @param string          $property The property that contains the proxy.
     * @param int|string|null $position The position in the collection. (or null)
     */
    public function __construct($forWhom, string $property, $position = null)
    {
        $this->forWhom = $forWhom;
        $this->property = $property;
        $this->position = $position;
    }

    public function attach(ObservesProxyLoading $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(ObservesProxyLoading $observer): void
    {
        unset($this->observers[array_search($observer, $this->observers, true)]);
    }

    final public function loadTheInstance()
    {
        $instance = $this->doLoad($this->forWhom, $this->property, $this->position);
        $this->tellThemWeMadeThis($instance);
        return $instance;
    }

    protected function tellThemWeMadeThis($instance): void
    {
        foreach ($this->observers as $observer) {
            $observer->updateWith($instance);
        }
    }

    protected abstract function doLoad($forWhom, string $property, $position = null);
}
