<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test;

use PHPUnit\Framework\TestCase;
use Stratadox\Proxy\PropertyUpdater;
use Stratadox\Proxy\PropertyUpdaterFactory;
use Stratadox\Proxy\UpdatesTheProxyOwner;

/**
 * @covers \Stratadox\Proxy\PropertyUpdaterFactory
 */
class PropertyUpdaterFactory_produces_updaters_for_properties extends TestCase
{
    /** @test */
    function making_a_PropertyUpdater()
    {
        $updater = (new PropertyUpdaterFactory)->makeUpdaterFor($this, 'foo');

        $this->assertInstanceOf(UpdatesTheProxyOwner::class, $updater);
        $this->assertEquals(PropertyUpdater::for($this, 'foo'), $updater);
    }
}
