<?php

namespace Stratadox\Proxy;

/**
 * Choice.
 *
 * @author Stratadox
 */
interface Choice extends ProxyFactory
{
    public function shouldUseFor(array $data): bool;
}
