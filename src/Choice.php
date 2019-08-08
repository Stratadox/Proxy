<?php

namespace Stratadox\Proxy;

/**
 * Choice: one of usually several choices to choose from when deciding on a
 * concrete proxy implementation.
 *
 * @author Stratadox
 */
interface Choice extends ProxyFactory
{
    /**
     * Checks whether this choice should be used for the known data.
     *
     * @param array $data The data we have on the proxied object.
     * @return bool       Whether to use this choice.
     */
    public function shouldUseFor(array $data): bool;
}
