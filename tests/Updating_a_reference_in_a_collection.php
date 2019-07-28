<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test;

use function array_keys;
use PHPUnit\Framework\TestCase;
use Stratadox\Proxy\ArrayEntryUpdate;
use Stratadox\Proxy\BasicProxyFactory;
use Stratadox\Proxy\Only;
use Stratadox\Proxy\Proxy;
use Stratadox\Proxy\Test\Domain\Collection\Car;
use Stratadox\Proxy\Test\Domain\Collection\Collector;
use Stratadox\Proxy\Test\Domain\Collection\LicensePlate;
use Stratadox\Proxy\Test\Infrastructure\Collection\CarProxy;
use Stratadox\Proxy\Test\Infrastructure\Collection\InMemoryCollectibleLoader;
use Stratadox\Proxy\Test\Support\PropertyProbing;
use Stratadox\Proxy\UpdatingLoader;

/**
 * @testdox Updating a reference in a collection
 */
class Updating_a_reference_in_a_collection extends TestCase
{
    use PropertyProbing;

    /** @test */
    function updating_a_reference_in_an_array()
    {
        $items = [
            new Car(new LicensePlate('real license plate')),
            new Car(new LicensePlate('other real license plate')),
            new Car(new LicensePlate('more real license plate')),
        ];
        $loader = UpdatingLoader::using(new InMemoryCollectibleLoader([
            'Richard Richman' => $items
        ]));
        $proxyFactory = BasicProxyFactory::for(
            CarProxy::class,
            $loader
        );

        // admittedly, client code gets sorta complex
        $proxies = [];
        foreach (array_keys($items) as $i) {
            $proxies[$i] = $proxyFactory->create([
                'owner' => 'Richard Richman',
                'offset' => $i,
            ]);
        }
        $collector = new Collector('Richard Richman', ...$proxies);
        foreach ($proxies as $i => $proxy) {
            $loader->schedule(
                ArrayEntryUpdate::of($collector, 'collection', $i, Only::when([
                    'owner' => 'Richard Richman',
                    'offset' => $i,
                ]))
            );
        }

        // checking this assertion should trigger array entry updates in 0 and 1
        $this->assertTrue($collector->owns($items[1]));

        $collection = $this->valueOf(Collector::class, $collector, 'collection');
        $this->assertNotInstanceOf(Proxy::class, $collection[1]);
        $this->assertInstanceOf(Proxy::class, $collection[2]);
    }
}
