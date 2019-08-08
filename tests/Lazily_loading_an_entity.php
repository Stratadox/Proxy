<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test;

use PHPUnit\Framework\TestCase;
use Stratadox\Deserializer\ObjectDeserializer;
use Stratadox\Deserializer\OneOfThese;
use Stratadox\Proxy\BasicProxyFactory;
use Stratadox\Proxy\DeserializingProxyFactory;
use Stratadox\Proxy\ProxyProductionFailed;
use Stratadox\Proxy\Test\Domain\FinalConstructor\FinalConstructor;
use Stratadox\Proxy\Test\Domain\Simple\SimpleEntity;
use Stratadox\Proxy\Test\Infrastructure\FinalConstructor\FinalConstructorLoader;
use Stratadox\Proxy\Test\Infrastructure\FinalConstructor\FinalConstructorProxy;
use Stratadox\Proxy\Test\Infrastructure\Simple\SimpleEntityProxy;
use Stratadox\Proxy\Test\Infrastructure\Simple\SuperSimpleLoader;
use Stratadox\Proxy\Test\Infrastructure\SpyingLoader;

/**
 * @testdox Lazily loading an entity
 */
class Lazily_loading_an_entity extends TestCase
{
    /** @test */
    function not_loading_the_real_entity_before_calling_upon_the_proxy()
    {
        // Arrange
        $loader = new SpyingLoader(new SuperSimpleLoader());
        $proxyFactory = BasicProxyFactory::for(SimpleEntityProxy::class, $loader);

        // Act
        $proxyFactory->create();

        // Assert
        $this->assertFalse($loader->hasLoaded());
    }

    /** @test */
    function loading_the_real_entity_when_calling_upon_the_proxy()
    {
        // Arrange
        $loader = new SpyingLoader(new SuperSimpleLoader());
        $proxyFactory = BasicProxyFactory::for(SimpleEntityProxy::class, $loader);

        // Act
        /** @var SimpleEntity $proxy */
        $proxy = $proxyFactory->create();

        $proxy->id();

        // Assert
        $this->assertTrue($loader->hasLoaded());
    }

    /** @test */
    function loading_the_real_entity_only_once()
    {
        // Arrange
        $loader = new SpyingLoader(new SuperSimpleLoader());
        $proxyFactory = BasicProxyFactory::for(SimpleEntityProxy::class, $loader);

        // Act
        /** @var SimpleEntity $proxy */
        $proxy = $proxyFactory->create();

        $proxy->id();
        $proxy->id();

        // Assert
        $this->assertSame(1, $loader->timesLoaded());
    }

    /** @test */
    function lazily_loading_an_object_with_final_constructor()
    {
        // Arrange
        $loader = new FinalConstructorLoader(new FinalConstructor('foo'));
        $proxyFactory = DeserializingProxyFactory::using(
            ObjectDeserializer::forThe(FinalConstructorProxy::class),
            $loader
        );

        // Act
        /** @var FinalConstructor $proxy */
        $proxy = $proxyFactory->create(['value' => 'foo']);

        // Assert
        $this->assertSame('foo', $proxy->value());
    }

    /** @test */
    function not_loading_non_proxies()
    {
        // Assert
        $this->expectExceptionMessage(
            'Cannot use non-proxy class `' .
            SimpleEntity::class .
            '` as proxy.'
        );

        // Act
        BasicProxyFactory::for(SimpleEntity::class, new SuperSimpleLoader());
    }

    /** @test */
    function not_producing_undeserializable_proxies()
    {
        // Arrange
        $proxyFactory = DeserializingProxyFactory::using(
            OneOfThese::deserializers(),
            new FinalConstructorLoader()
        );

        $this->expectException(ProxyProductionFailed::class);

        // Act
        $proxyFactory->create(['value' => 'foo']);
    }
}
