<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use function spl_object_id;

class ProxyLoadingAdapter
{
    private $loader;
    private $data = [];

    private function __construct(ProxyLoader $loader)
    {
        $this->loader = $loader;
    }

    public static function using(ProxyLoader $loader): self
    {
        return new self($loader);
    }

    /** @throws ProxyLoadingFailure */
    public function load(Proxy $object): object
    {
        return $this->loader->loadTheInstance(
            $this->data[spl_object_id($object)] ?? []
        );
    }

    public function attachDataTo(Proxy $object, array $data): void
    {
        $this->data[spl_object_id($object)] = $data;
    }
}
