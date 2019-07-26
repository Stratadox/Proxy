<?php declare(strict_types=1);

namespace Stratadox\Proxy;

final class UpdatingLoader implements ReferenceUpdatingLoader
{
    /** @var PropertyUpdate[] */
    private $update = [];
    private $loader;

    private function __construct(ProxyLoader $loader)
    {
        $this->loader = $loader;
    }

    public static function using(ProxyLoader $loader): ReferenceUpdatingLoader
    {
        return new self($loader);
    }

    public function loadTheInstance(array $proxy): object
    {
        $instance = $this->loader->loadTheInstance($proxy);
        foreach ($this->update as $update) {
            $update->with($instance);
        }
        return $instance;
    }

    public function schedule(PropertyUpdate $update): void
    {
        $this->update[] = $update;
    }
}
