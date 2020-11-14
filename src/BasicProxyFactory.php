<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use InvalidArgumentException;
use function is_a;
use function sprintf;

/**
 * Basic Proxy Factory; Produces proxies, feeding them with whatever data we
 * have on the object they represent.
 *
 * @author Stratadox
 */
final class BasicProxyFactory implements ProxyFactory
{
    /** @var string */
    private $class;
    /** @var ProxyLoader */
    private $loader;

    private function __construct(
        string $class,
        ProxyLoader $loader
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

    /**
     * Makes a proxy factory for a particular proxy class.
     *
     * @param string      $class  The proxy class to instantiate.
     * @param ProxyLoader $loader The loader to inject into the proxy.
     * @return ProxyFactory       The factory for this proxy class.
     */
    public static function for(string $class, ProxyLoader $loader): ProxyFactory
    {
        return new self($class, $loader);
    }

    /** @inheritdoc */
    public function create(array $knownData = []): Proxy
    {
        return new $this->class($this->loader, $knownData);
    }
}
