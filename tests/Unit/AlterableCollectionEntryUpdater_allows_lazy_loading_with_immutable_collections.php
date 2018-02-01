<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test;

use PHPUnit\Framework\TestCase;
use Stratadox\Proxy\AlterableCollectionEntryUpdater;
use Stratadox\Proxy\Test\Foo\Foo;
use Stratadox\Proxy\Test\Foo\FooProxy;
use Stratadox\Proxy\Test\Foo\Foos;
use Stratadox\Proxy\UnexpectedPropertyType;

/**
 * @covers \Stratadox\Proxy\AlterableCollectionEntryUpdater
 * @covers \Stratadox\Proxy\UnexpectedPropertyType
 */
class AlterableCollectionEntryUpdater_allows_lazy_loading_with_immutable_collections extends TestCase
{
    private $alterTheEntry;

    /** @scenario */
    function updating_private_immutable_collection_of_the_owner()
    {
        $this->alterTheEntry = new Foos(
            new FooProxy(),
            new FooProxy()
        );

        $updater = AlterableCollectionEntryUpdater::for($this, 'alterTheEntry', 1);

        $foo = new Foo();
        $updater->updateWith($foo);

        $this->assertSame($foo, $this->alterTheEntry[1]);
    }

    /** @scenario */
    function the_value_must_have_the_expected_type()
    {
        $this->alterTheEntry = [
            new FooProxy(),
            new FooProxy()
        ];

        $updater = AlterableCollectionEntryUpdater::for($this, 'alterTheEntry', 1);

        $this->expectException(UnexpectedPropertyType::class);
        $this->expectExceptionMessage(sprintf(
            'Could not assign the value for `%s::alterTheEntry`, got an `array` ' .
            'instead of `Stratadox\\Collection\\Alterable`',
            get_class($this)
        ));
        $updater->updateWith(new Foo());
    }
}
