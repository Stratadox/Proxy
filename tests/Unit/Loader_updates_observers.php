<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test;

use PHPUnit\Framework\TestCase;
use Stratadox\Proxy\Test\Foo\FooLoader;
use Stratadox\Proxy\Test\Foo\FooLoadingObserver;

/**
 * @covers \Stratadox\Proxy\Loader
 */
class Loader_updates_observers extends TestCase
{
    /** @test */
    function update_with_result_after_loading()
    {
        $observer = new FooLoadingObserver;
        $loader = new FooLoader(null, '');

        $loader->attach($observer);
        $foo = $loader->loadTheInstance();

        $this->assertSame($foo, $observer->instance());
    }

    /** @test */
    function call_nobody_when_unobserved()
    {
        $observer = new FooLoadingObserver;
        $loader = new FooLoader(null, '');

        $loader->loadTheInstance();

        $this->assertNull($observer->instance());
    }

    /** @test */
    function do_not_update_before_loading()
    {
        $observer = new FooLoadingObserver;
        $loader = new FooLoader(null, '');

        $loader->attach($observer);

        $this->assertNull($observer->instance());
    }

    /** @test */
    function do_not_update_if_detached()
    {
        $observer = new FooLoadingObserver;
        $loader = new FooLoader(null, '');

        $loader->attach($observer);
        $loader->detach($observer);
        $loader->loadTheInstance();

        $this->assertNull($observer->instance());
    }
}
