<?php

namespace Stratadox\Proxy;

/**
 * Proxy.
 *
 * @author Stratadox
 */
interface Proxy
{
    /**
     * Required in order to be able to easily create the proxy and all its data
     *
     * @param ProxyLoader $loader     The loader responsible for retrieving the
     *                                proxied object.
     * @param array        $knownData A map of known data about the proxied
     *                                object.
     */
    public function __construct(ProxyLoader $loader, array $knownData);
}
