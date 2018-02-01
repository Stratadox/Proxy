<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test\Foo;

use Stratadox\Proxy\Proxy;
use Stratadox\Proxy\Proxying;

class FooProxy extends Foo implements Proxy
{
    use Proxying;

    function bar() : string
    {
        return $this->__load()->bar();
    }
}
