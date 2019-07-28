<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Infrastructure;

use Stratadox\Proxy\ProxyLoader;

final class SpyingLoader implements ProxyLoader
{
    private $loaded = 0;
    private $loader;

    public function __construct(ProxyLoader $loader)
    {
        $this->loader = $loader;
    }

    public function loadTheInstance(array $data): object
    {
        $this->loaded++;
        return $this->loader->loadTheInstance($data);
    }

    public function hasLoaded(): bool
    {
        return $this->loaded > 0;
    }

    public function timesLoaded(): int
    {
        return $this->loaded;
    }
}
