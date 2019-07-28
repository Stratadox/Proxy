<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Domain\Collection;

use function array_filter;

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
