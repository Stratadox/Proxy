<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test;

use PHPUnit\Framework\TestCase;
use Stratadox\Proxy\AlterableCollectionEntryUpdater;
use Stratadox\Proxy\AlterableCollectionEntryUpdaterFactory;
use Stratadox\Proxy\UpdatesTheProxyOwner;

/**
 * @covers \Stratadox\Proxy\AlterableCollectionEntryUpdaterFactory
 */
class AlterableCollectionEntryUpdaterFactory_produces_updaters_for_collection_entries extends TestCase
{
    /** @test */
    function making_an_AlterableCollectionEntryUpdater()
    {
        $updater = (new AlterableCollectionEntryUpdaterFactory)->makeUpdaterFor($this, 'foo', 10);

        $this->assertInstanceOf(UpdatesTheProxyOwner::class, $updater);
        $this->assertEquals(AlterableCollectionEntryUpdater::forThe($this, 'foo', 10), $updater);
    }
}
