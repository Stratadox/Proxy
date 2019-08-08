<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test;

use PHPUnit\Framework\TestCase;
use Stratadox\Proxy\BasicProxyFactory;
use Stratadox\Proxy\Test\Domain\Simple\SimpleEntity;
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
}
