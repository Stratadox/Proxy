<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Infrastructure\Collection;

use Stratadox\Proxy\Test\Domain\Collection\Collectible;
use Stratadox\Proxy\ProxyLoader;

final class InMemoryCollectibleLoader implements ProxyLoader
{
    private $collectibles;

    public function __construct(array $collections)
    {
        foreach ($collections as $name => $collection) {
            $this->setCollectionFor($name, ...$collection);
        }
    }

    private function setCollectionFor(string $owner, Collectible ...$collectibles)
    {
        $this->collectibles[$owner] = $collectibles;
    }

    public function loadTheInstance(array $data): object
    {
        return $this->collectibles[$data['owner']][$data['offset']];
    }
}
