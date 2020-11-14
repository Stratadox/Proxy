<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use Stratadox\Proxy\When\KeyMatches;

/**
 * CompositeProxyFactory. Creates a proxy, choosing its concrete implementation
 * based on the known data for the proxied entity.
 *
 * @author Stratadox
 */
final class CompositeProxyFactory implements ProxyFactory
{
    /** @var Choice[] */
    private $choices;

    private function __construct(Choice ...$choices)
    {
        $this->choices = $choices;
    }

    /**
     * Makes a new composite factory that decides on a proxy implementation
     * based on a key.
     *
     * @param string $key       The key to check for.
     * @param array  $factories A set of expected values with associated factory.
     * @return ProxyFactory     The composite factory that decides based on a key.
     */
    public static function decidingBy(string $key, array $factories): ProxyFactory
    {
        $choices = [];
        foreach ($factories as $value => $factory) {
            $choices[] = Maybe::the($factory, KeyMatches::with($key, $value));
        }
        return new self(...$choices);
    }

    /**
     * Makes a new composite factory that decides on a proxy implementation
     * based on a set of choices.
     *
     * @param Choice ...$choices The choices to involve.
     * @return ProxyFactory      The composite factory.
     */
    public static function using(Choice ...$choices): ProxyFactory
    {
        return new self(...$choices);
    }

    /** @inheritdoc */
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
