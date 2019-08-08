<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Infrastructure\FinalConstructor;

use Stratadox\Proxy\Proxy;
use Stratadox\Proxy\ProxyingWithoutConstructor;
use Stratadox\Proxy\Test\Domain\FinalConstructor\FinalConstructor;

final class FinalConstructorProxy extends FinalConstructor implements Proxy
{
    use ProxyingWithoutConstructor;

    public function value(): string
    {
        return $this->_load()->value();
    }
}
