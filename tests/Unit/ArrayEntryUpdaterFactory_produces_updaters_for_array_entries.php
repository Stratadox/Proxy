<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\Proxy\ArrayEntryUpdater;
use Stratadox\Proxy\ArrayEntryUpdaterFactory;
use Stratadox\Proxy\UpdatesTheProxyOwner;

/**
 * @covers \Stratadox\Proxy\ArrayEntryUpdaterFactory
 */
class ArrayEntryUpdaterFactory_produces_updaters_for_array_entries extends TestCase
{
    /** @test */
    function making_an_ArrayEntryUpdater()
    {
        $updater = (new ArrayEntryUpdaterFactory)->makeUpdaterFor($this, 'foo', 10);

        $this->assertInstanceOf(UpdatesTheProxyOwner::class, $updater);
        $this->assertEquals(ArrayEntryUpdater::forThe($this, 'foo', 10), $updater);
    }
}
