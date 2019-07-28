<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Domain\Collection;

interface Collectible
{
    public function isIndeed(Collectible $other): bool;
    public function needsMaintenance(): bool;
}
