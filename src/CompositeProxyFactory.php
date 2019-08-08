<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use Stratadox\Proxy\When\KeyMatches;

/**
 * CompositeProxyFactory.
 *
 * @author Stratadox
 */
final class CompositeProxyFactory implements ProxyFactory
{
    private $choices;

    private function __construct(Choice ...$choices)
    {
        $this->choices = $choices;
    }

    public static function decidingBy(string $key, array $factories): ProxyFactory
    {
        $choices = [];
        foreach ($factories as $value => $factory) {
            $choices[] = Maybe::the($factory, KeyMatches::with($key, $value));
        }
        return new self(...$choices);
    }

    public static function using(Choice ...$choices): ProxyFactory
    {
        return new self(...$choices);
    }

    public function create(array $knownData = []): Proxy
    {
        foreach ($this->choices as $choice) {
            if ($choice->shouldUseFor($knownData)) {
                return $choice->create($knownData);
            }
        }
        throw NoFactoryFound::forData($knownData);
    }
}
