<?php

namespace Stratadox\Proxy;

/**
 * ProxyFactory.
 *
 * @author Stratadox
 */
interface ProxyFactory
{
    /**
     * Creates a new proxy.
     *
     * @param array $knownData A map of known data about the proxied object.
     * @return Proxy           The lazy proxy for the object.
     */
    public function create(array $knownData = []): Proxy;
}
