<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test;

use PHPUnit\Framework\TestCase;
use Stratadox\Proxy\BasicProxyFactory;
use Stratadox\Proxy\Test\Domain\Simple\SimpleEntity;
use Stratadox\Proxy\Test\Domain\Simple\SimpleValue;
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
}
