<?php

namespace Stratadox\Proxy;

interface ProxyFactory
{
    public function create(array $knownData = []): Proxy;
}
