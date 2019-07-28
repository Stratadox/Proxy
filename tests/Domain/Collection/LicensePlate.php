<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Domain\Collection;

class LicensePlate
{
    private $plateSequence;

    public function __construct(string $plateSequence)
    {
        $this->plateSequence = $plateSequence;
    }

    public function sequence(): string
    {
        return $this->plateSequence;
    }

    public function isSameAs(LicensePlate $other): bool
    {
        return $this->sequence() === $other->sequence();
    }

    public function __toString(): string
    {
        return $this->plateSequence;
    }
}
