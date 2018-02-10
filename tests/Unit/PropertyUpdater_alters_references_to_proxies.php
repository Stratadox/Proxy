<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test;

use PHPUnit\Framework\TestCase;
use Stratadox\Proxy\PropertyUpdater;
use Stratadox\Proxy\Test\Foo\Foo;
use Stratadox\Proxy\Test\Foo\FooProxy;

/**
 * @covers \Stratadox\Proxy\PropertyUpdater
 */
class PropertyUpdater_alters_references_to_proxies extends TestCase
{
    private $alterTheProperty;

    /** @test */
    function altering_private_properties_of_the_owner()
    {
        $this->alterTheProperty = new FooProxy();

        $updater = PropertyUpdater::for($this, 'alterTheProperty');

        $foo = new Foo();
        $updater->updateWith($foo);

        $this->assertSame($foo, $this->alterTheProperty);
    }
}
