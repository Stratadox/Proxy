<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use InvalidArgumentException;
use function is_a;
use function sprintf;

final class BasicProxyFactory implements ProxyFactory
{
    private $class;
    private $loader;

    private function __construct(
        string $class,
        ProxyLoadingAdapter $loader
    ) {
        $this->class = $class;
        $this->loader = $loader;
        if (!is_a($class, Proxy::class, true)) {
            throw new InvalidArgumentException(sprintf(
                'Cannot use non-proxy class `%s` as proxy.',
                $class
            ));
        }
    }

    public static function for(string $class, ProxyLoader $loader): ProxyFactory
    {
        return new self($class, ProxyLoadingAdapter::using($loader));
    }

    public function create(array $knownData = []): Proxy
    {
        $proxy = new $this->class($this->loader);
        $this->loader->attachDataTo($proxy, $knownData);
        return $proxy;
    }
}