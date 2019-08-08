<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Domain\Collection;

/**
 * MaintenanceRequest.
 *
 * @author Stratadox
 */
class MaintenanceRequest
{
    /** @var iterable|Collectible[] */
    private $items;

    public function __construct(Collectible ...$items)
    {
        $this->items = $items;
    }

    public function items(): iterable
    {
        return $this->items;
    }
}
