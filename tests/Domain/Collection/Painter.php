<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Domain\Collection;

/**
 * A painter paints paintings.
 *
 * @author Stratadox
 */
class Painter
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function named(string $name): self
    {
        return new self($name);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isTheSameAs(Painter $other): bool
    {
        return $this->name === $other->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
