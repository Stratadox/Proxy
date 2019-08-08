<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Domain\FinalConstructor;

class FinalConstructor
{
    private $value;

    final public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
