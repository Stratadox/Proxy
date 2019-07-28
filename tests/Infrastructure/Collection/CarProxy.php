<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Infrastructure\Collection;

use Stratadox\Proxy\Test\Domain\Collection\Car;
use Stratadox\Proxy\Test\Domain\Collection\Collectible;
use Stratadox\Proxy\Proxy;
use Stratadox\Proxy\Proxying;
use Stratadox\Proxy\Test\Domain\Collection\LicensePlate;

final class CarProxy extends Car implements Proxy
{
    use Proxying;

    public function isIndeed(Collectible $other): bool
    {
        return $this->_load()->isIndeed($other);
    }

    public function needsMaintenance(): bool
    {
        return $this->_load()->needsMaintenance();
    }

    public function takeDamage(): void
    {
        $this->_load()->takeDamage();
    }

    public function plate(): LicensePlate
    {
        return $this->_load()->plate();
    }
}
