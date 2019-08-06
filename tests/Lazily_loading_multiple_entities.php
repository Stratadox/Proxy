<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test;

use function assert;
use PHPUnit\Framework\TestCase;
use Stratadox\Proxy\BasicProxyFactory;
use Stratadox\Proxy\CompositeProxyFactory;
use Stratadox\Proxy\Test\Domain\Collection\Car;
use Stratadox\Proxy\Test\Domain\Collection\Collectible;
use Stratadox\Proxy\Test\Domain\Collection\Collector;
use Stratadox\Proxy\Test\Domain\Collection\Painting;
use Stratadox\Proxy\Test\Domain\Simple\SimpleEntity;
use Stratadox\Proxy\Test\Domain\Simple\SimpleValue;
use Stratadox\Proxy\Test\Infrastructure\Collection\CarProxy;
use Stratadox\Proxy\Test\Infrastructure\Collection\InMemoryCollectibleLoader;
use Stratadox\Proxy\Test\Infrastructure\Collection\PaintingProxy;
use Stratadox\Proxy\Test\Infrastructure\Simple\InMemorySimpleEntityLoader;
use Stratadox\Proxy\Test\Infrastructure\Simple\SimpleEntityProxy;

/**
 * @testdox Lazily loading multiple entities
 */
class Lazily_loading_multiple_entities extends TestCase
{
    /** @test */
    function loading_two_proxies_with_previously_known_identifiers()
    {
        $loader = new InMemorySimpleEntityLoader([
            'id-01' => SimpleEntity::withIdAndAttribute('id-01', 'foo'),
            'id-02' => SimpleEntity::withIdAndAttribute('id-02', 'bar'),
        ]);
        $proxyFactory = BasicProxyFactory::for(SimpleEntityProxy::class, $loader);

        /** @var SimpleEntity $entity1 */
        $entity1 = $proxyFactory->create(['id' => 'id-01']);
        /** @var SimpleEntity $entity2 */
        $entity2 = $proxyFactory->create(['id' => 'id-02']);

        $this->assertSame('id-01', $entity1->id());
        $this->assertTrue(
            SimpleValue::withValue('foo')->equals($entity1->attribute())
        );
        $this->assertSame('id-02', $entity2->id());
        $this->assertTrue(
            SimpleValue::withValue('bar')->equals($entity2->attribute())
        );
    }

    /** @test */
    function loading_several_proxies_of_different_concrete_types()
    {
        $items = [
            Car::withPlateNumber('foo'),
            Car::withPlateNumber('bar'),
            Car::withPlateNumber('baz'),
            Painting::by('Famous Painter', 'Work of art #1'),
            Painting::by('Incredible Painter', 'Masterpiece'),
        ];
        $loader = new InMemoryCollectibleLoader(['Richard Richman' => $items]);
        $proxyFactory = CompositeProxyFactory::decidingBy('type', [
            'car' => BasicProxyFactory::for(CarProxy::class, $loader),
            'painting' => BasicProxyFactory::for(PaintingProxy::class, $loader),
        ]);

        /** @var Collectible[] $proxies */
        $proxies = [];
        foreach ($items as $i => $realItem) {
            $proxy = $proxyFactory->create([
                'owner' => 'Richard Richman',
                'offset' => $i,
                'type' => $realItem instanceof Car ? 'car' : 'painting'
            ]);
            assert($proxy instanceof Collectible);
            $proxies[] = $proxy;
        }
        $collector = new Collector('Richard Richman', ...$proxies);

        $this->assertFalse($collector->owns(Car::withPlateNumber('nope')));
        $this->assertFalse($collector->owns(Painting::by('Schmuck', 'Trash')));
        foreach ($items as $thatItem) {
            $this->assertTrue($collector->owns($thatItem));
        }
    }
}
