<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Domain\Collection;

class Painting implements Collectible
{
    private $painter;
    private $name;
    private $maybeLookAt = 0;

    public function __construct(Painter $painter, string $name)
    {
        $this->painter = $painter;
        $this->name = $name;
    }

    public static function by(string $painterName, string $paintingName): self
    {
        return new self(Painter::named($painterName), $paintingName);
    }

    public function isIndeed(Collectible $other): bool
    {
        return $other instanceof Painting
            && $this->painter->isTheSameAs($other->painter())
            && $this->name === $other->name();
    }

    public function painter(): Painter
    {
        return $this->painter;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function needsMaintenance(): bool
    {
        return $this->maybeLookAt > 3;
    }

    public function moveAround(): void
    {
        $this->maybeLookAt++;
    }

    public function exposeToLight(): void
    {
        $this->maybeLookAt++;
    }

    public function exposeToHumidity(): void
    {
        $this->maybeLookAt += 1.5;
    }

    public function exposeToChildren(): void
    {
        $this->maybeLookAt += 10;
    }
}
