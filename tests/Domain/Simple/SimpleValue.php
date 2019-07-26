<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Domain\Simple;

class SimpleValue
{
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function withValue(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(SimpleValue $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString()
    {
        return $this->value();
    }
}
