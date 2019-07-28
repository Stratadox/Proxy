<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Domain\Collection;

class Car implements Collectible
{
    private $plate;
    private $damage = 0;

    public function __construct(LicensePlate $plate)
    {
        $this->plate = $plate;
    }

    public static function withPlateNumber(string $sequence): self
    {
        return new self(new LicensePlate($sequence));
    }

    public function isIndeed(Collectible $other): bool
    {
        return $other instanceof Car
            && $this->plate->isSameAs($other->plate());
    }

    public function needsMaintenance(): bool
    {
        return $this->damage > 0;
    }

    public function takeDamage(): void
    {
        $this->damage++;
    }

    public function plate(): LicensePlate
    {
        return $this->plate;
    }
}
