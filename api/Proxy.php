<?php

namespace Stratadox\Proxy;

interface Proxy
{
    public function __construct(ProxyLoader $loader, array $knownData);
}
