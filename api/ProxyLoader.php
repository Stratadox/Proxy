<?php

namespace Stratadox\Proxy;

/**
 * ProxyLoader.
 *
 * @author Stratadox
 */
interface ProxyLoader
{
    /**
     * Loads the proxied instance, based on the available data.
     *
     * @param array $data A map of known data about the proxied object.
     * @return object     The object the proxy is proxying for.
     */
    public function loadTheInstance(array $data): object;
}
