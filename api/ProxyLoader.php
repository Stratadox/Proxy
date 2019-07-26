<?php

namespace Stratadox\Proxy;

interface ProxyLoader
{
    public function loadTheInstance(array $data): object;
}
