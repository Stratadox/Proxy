<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Infrastructure\Collection;

use Stratadox\Proxy\Proxy;
use Stratadox\Proxy\Proxying;
use Stratadox\Proxy\Test\Domain\Collection\Collectible;
use Stratadox\Proxy\Test\Domain\Collection\Painter;
use Stratadox\Proxy\Test\Domain\Collection\Painting;

final class PaintingProxy extends Painting implements Proxy
{
    use Proxying;

    public function isIndeed(Collectible $other): bool
    {
        return $this->_load()->isIndeed($other);
    }

    public function painter(): Painter
    {
        return $this->_load()->painter();
    }

    public function name(): string
    {
        return $this->_load()->name();
    }

    public function needsMaintenance(): bool
    {
        return $this->_load()->needsMaintenance();
    }

    public function moveAround(): void
    {
        $this->_load()->moveAround();
    }

    public function exposeToLight(): void
    {
        $this->_load()->exposeToLight();
    }

    public function exposeToHumidity(): void
    {
        $this->_load()->exposeToHumidity();
    }

    public function exposeToChildren(): void
    {
        $this->_load()->exposeToChildren();
    }
}
