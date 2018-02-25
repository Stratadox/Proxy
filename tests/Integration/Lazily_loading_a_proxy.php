<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test\Integration;

use PHPUnit\Framework\TestCase;
use Stratadox\Hydrator\SimpleHydrator;
use Stratadox\Proxy\ProducesProxies;
use Stratadox\Proxy\PropertyUpdaterFactory;
use Stratadox\Proxy\ProxyFactory;
use Stratadox\Proxy\Test\Bar\Bar;
use Stratadox\Proxy\Test\Bar\BarLoaderFactory;
use Stratadox\Proxy\Test\Bar\BarProxy;
use Stratadox\Proxy\Test\Foo\Foo;
use Stratadox\Proxy\Test\Foo\FooLoaderFactory;
use Stratadox\Proxy\Test\Foo\FooProxy;

/**
 * @coversNothing because integration test
 */
class Lazily_loading_a_proxy extends TestCase
{
    /** @var Foo */
    private $foo;

    /** @var Bar */
    private $bar;

    /** @test */
    function creating_a_proxy_in_a_property_and_loading_it_when_called_upon()
    {
        $foo = $this->fooProxyMaker()->createFor($this, 'foo');

        if ($foo instanceof Foo) {
            $this->foo = $foo;
        }

        $this->assertInstanceOf(FooProxy::class, $this->foo);

        $this->assertSame('baz', $this->foo->bar());

        $this->assertNotInstanceOf(FooProxy::class, $this->foo);
        $this->assertInstanceOf(Foo::class, $this->foo);
    }

    /** @test */
    function loaders_receive_information_on_which_object_to_load()
    {
        $bar = $this->barProxyMaker()->createFor($this, 'bar');

        if ($bar instanceof Bar) {
            $this->bar = $bar;
        }

        $this->assertSame($this, $this->bar->madeBy());
        $this->assertSame('bar', $this->bar->inProperty());
    }

    private function fooProxyMaker(): ProducesProxies
    {
        return ProxyFactory::fromThis(
            SimpleHydrator::forThe(FooProxy::class),
            new FooLoaderFactory,
            new PropertyUpdaterFactory
        );
    }

    private function barProxyMaker(): ProducesProxies
    {
        return ProxyFactory::fromThis(
            SimpleHydrator::forThe(BarProxy::class),
            new BarLoaderFactory,
            new PropertyUpdaterFactory
        );
    }
}
