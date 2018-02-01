<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test\Bar;

use Stratadox\Proxy\Proxy;
use Stratadox\Proxy\Proxying;

class BarProxy extends Bar implements Proxy
{
    use Proxying;

    public function madeBy()
    {
        return $this->__load()->madeBy();
    }

    public function inProperty() : string
    {
        return $this->__load()->inProperty();
    }
}
