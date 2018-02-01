<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test\Foo;

use Stratadox\Proxy\ObservesProxyLoading;

class FooLoadingObserver implements ObservesProxyLoading
{
    private $instance;

    public function updateWith($theLoadedInstance) : void
    {
        $this->instance = $theLoadedInstance;
    }

    public function instance()
    {
        return $this->instance;
    }
}
