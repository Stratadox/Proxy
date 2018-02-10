<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test;

use PHPUnit\Framework\TestCase;
use Stratadox\Hydrator\SimpleHydrator;
use Stratadox\Proxy\ProducesProxies;
use Stratadox\Proxy\Proxy;
use Stratadox\Proxy\ProxyFactory;
use Stratadox\Proxy\Test\Foo\FooLoaderFactory;
use Stratadox\Proxy\Test\Foo\FooProxy;
use Stratadox\Proxy\PropertyUpdaterFactory;

/**
 * @covers \Stratadox\Proxy\ProxyFactory
 */
class ProxyFactory_produces_proxies_for_lazy_relationships extends TestCase
{
    /** @var ProducesProxies */
    private $builder;

    /** @test */
    function making_a_proxy_object()
    {
        $proxy = $this->builder->createFor($this, 'proxy');

        $this->assertInstanceOf(Proxy::class, $proxy);
    }

    protected function setUp()
    {
        $this->builder = ProxyFactory::fromThis(
            SimpleHydrator::forThe(FooProxy::class),
            new FooLoaderFactory,
            new PropertyUpdaterFactory
        );
    }
}
