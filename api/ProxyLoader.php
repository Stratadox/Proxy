<?php

namespace Stratadox\Proxy;

interface ProxyLoader
{
    /** @throws ProxyLoadingFailure */
    public function loadTheInstance(array $data): object;
}
