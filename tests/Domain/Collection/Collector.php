<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Domain\Collection;

/**
 * The Collector owns a number of collectibles. Since a collectible can have
 * a number of implementations, in this case either a painting or a car, we
 * can't be entirely sure which proxy class to load without knowing something
 * about the collectible item beforehand.
 *
 * @author Stratadox
 */
class Collector
{
    private $name;
    private $collection;

    public function __construct(string $name, Collectible ...$collection)
    {
        $this->name = $name;
        $this->collection = $collection;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function collect(Collectible $item): void
    {
        $this->collection[] = $item;
    }

    public function owns(Collectible $thatItem): bool
    {
        foreach ($this->collection as $myItem) {
            if ($thatItem->isIndeed($myItem)) {
                return true;
            }
        }
        return false;
    }

    public function produceMaintenanceRequest(): MaintenanceRequest
    {
        return new MaintenanceRequest(...array_filter(
            $this->collection,
            function (Collectible $item): bool {
                return $item->needsMaintenance();
            }
        ));
    }
}
