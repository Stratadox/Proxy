<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test\Unit;

use LogicException;
use PHPUnit\Framework\TestCase;
use Stratadox\Deserializer\ObjectDeserializer;
use Stratadox\Proxy\ProducesProxies;
use Stratadox\Proxy\ProxyFactory;
use Stratadox\Proxy\Test\Foo\Foo;
use Stratadox\Proxy\Test\Foo\FooLoaderFactory;
use Stratadox\Proxy\Test\Foo\FooProxy;
use Stratadox\Proxy\PropertyUpdaterFactory;

/**
 * @covers \Stratadox\Proxy\Proxying
 */
class Proxying_objects_are_lazily_loaded_placeholders extends TestCase
{
    /** @var ProducesProxies */
    private $builder;

    /** @test */
    function loading_the_proxied_instance_when_called_upon()
    {
        $proxy = $this->builder->createFor($this, 'proxy');

        $this->assertInstanceOf(Foo::class, $proxy->__load());
    }

    /** @test */
    function redirecting_all_calls_to_the_loaded_instance()
    {
        /** @var FooProxy $proxy */
        $proxy = $this->builder->createFor($this, 'proxy');

        $this->assertEquals('baz', $proxy->bar());
    }

    /** @test */
    function cannot_load_a_proxied_instance_without_loader()
    {
        $proxy = new FooProxy;

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            'Cannot load the proxy without a loader. Proxy class: '.FooProxy::class
        );

        $proxy->__load();
    }

    protected function setUp()
    {
        $this->builder = ProxyFactory::fromThis(
            ObjectDeserializer::forThe(FooProxy::class),
            new FooLoaderFactory,
            new PropertyUpdaterFactory
        );
    }
}
