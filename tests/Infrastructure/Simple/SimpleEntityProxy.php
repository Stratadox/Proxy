<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Infrastructure\Simple;

use Stratadox\Proxy\Proxy;
use Stratadox\Proxy\Proxying;
use Stratadox\Proxy\Test\Domain\Simple\SimpleEntity;
use Stratadox\Proxy\Test\Domain\Simple\SimpleValue;

final class SimpleEntityProxy extends SimpleEntity implements Proxy
{
    use Proxying;

    public function id(): string
    {
        return $this->_load()->id();
    }

    public function attribute(): SimpleValue
    {
        return $this->_load()->attribute();
    }

    public function changeAttribute(SimpleValue $attribute): void
    {
        $this->_load()->changeAttribute($attribute);
    }

    public function equals(SimpleEntity $other): bool
    {
        return $this->_load()->equals($other);
    }
}
