<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\Proxy\ArrayEntryUpdater;
use Stratadox\Proxy\Test\Foo\Foo;
use Stratadox\Proxy\Test\Foo\FooProxy;

/**
 * @covers \Stratadox\Proxy\ArrayEntryUpdater
 */
class ArrayEntryUpdater_allows_lazy_loading_with_arrays extends TestCase
{
    private $alterTheEntry;

    /** @test */
    function updating_private_array_of_the_owner()
    {
        $this->alterTheEntry = [
            new FooProxy,
            new FooProxy
        ];

        $updater = ArrayEntryUpdater::forThe($this, 'alterTheEntry', 1);

        $foo = new Foo;
        $updater->updateWith($foo);

        $this->assertSame($foo, $this->alterTheEntry[1]);
    }
}
