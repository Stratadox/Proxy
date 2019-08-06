<?php declare(strict_types=1);

namespace Stratadox\Proxy;

/**
 * CompositeProxyFactory.
 *
 * @author Stratadox
 */
final class CompositeProxyFactory implements ProxyFactory
{
    private $key;
    /** @var ProxyFactory[] */
    private $factories;

    public function __construct(string $decisionKey, array $factories)
    {
        $this->key = $decisionKey;
        foreach ($factories as $key => $factory) {
            $this->addFactory($key, $factory);
        }
    }

    private function addFactory(string $key, ProxyFactory $factory): void
    {
        $this->factories[$key] = $factory;
    }

    public static function decidingBy(string $key, array $factories): self
    {
        return new self($key, $factories);
    }

    public function create(array $knownData = []): Proxy
    {
        return $this->factories[$knownData[$this->key]]->create($knownData);
    }
}
