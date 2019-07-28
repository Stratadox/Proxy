<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test;

use LogicException;
use PHPUnit\Framework\TestCase;
use Stratadox\Hydrator\ReflectiveHydrator;
use Stratadox\Hydrator\ScopedHydrator;
use Stratadox\Proxy\PropertyUpdate;
use Stratadox\Proxy\Proxy;
use Stratadox\Proxy\BasicProxyFactory;
use Stratadox\Proxy\Test\Domain\Simple\SimpleEntity;
use Stratadox\Proxy\Test\Support\PropertyProbing;
use Stratadox\Proxy\UpdatingLoader;
use Stratadox\Proxy\Test\Domain\Simple\SimpleRootInheritor;
use Stratadox\Proxy\Test\Infrastructure\Simple\SimpleEntityProxy;
use Stratadox\Proxy\Test\Domain\Simple\SimpleRoot;
use Stratadox\Proxy\Test\Infrastructure\Simple\SuperSimpleLoader;

/**
 * @testdox Updating a reference upon loading
 */
class Updating_a_reference extends TestCase
{
    use PropertyProbing;

    /** @test */
    function only_updating_the_reference_after_the_proxy_got_loaded()
    {
        $loader = UpdatingLoader::using(new SuperSimpleLoader());
        $proxyFactory = BasicProxyFactory::for(
            SimpleEntityProxy::class,
            $loader
        );

        /** @var SimpleEntityProxy $proxy */
        $proxy = $proxyFactory->create();
        $root = new SimpleRoot('1', $proxy);

        $loader->schedule(PropertyUpdate::of($root, 'entity'));

        $this->assertInstanceOf(
            Proxy::class,
            $this->valueOf(SimpleRoot::class, $root, 'entity')
        );
    }

    /** @test */
    function updating_the_reference_after_the_proxy_got_loaded()
    {
        $loader = UpdatingLoader::using(new SuperSimpleLoader());
        $proxyFactory = BasicProxyFactory::for(
            SimpleEntityProxy::class,
            $loader
        );

        /** @var SimpleEntityProxy $proxy */
        $proxy = $proxyFactory->create();
        $root = new SimpleRoot('x', $proxy);

        $loader->schedule(PropertyUpdate::of($root, 'entity'));

        $root->value();

        $this->assertNotInstanceOf(
            Proxy::class,
            $this->valueOf(SimpleRoot::class, $root, 'entity')
        );
    }

    /** @test */
    function updating_the_reference_in_an_inherited_private_property()
    {
        $loader = UpdatingLoader::using(new SuperSimpleLoader());
        $proxyFactory = BasicProxyFactory::for(
            SimpleEntityProxy::class,
            $loader
        );

        /** @var SimpleEntityProxy $proxy */
        $proxy = $proxyFactory->create();
        $root = new SimpleRootInheritor('123', $proxy);

        $loader->schedule(
            PropertyUpdate::using(ReflectiveHydrator::default(), $root, 'entity')
        );

        $root->value();

        $this->assertNotInstanceOf(
            Proxy::class,
            $this->valueOf(SimpleRoot::class, $root, 'entity')
        );
    }

    /** @test */
    function failing_to_load_when_the_property_could_not_be_hydrated()
    {
        $loader = UpdatingLoader::using(new SuperSimpleLoader());
        $proxyFactory = BasicProxyFactory::for(
            SimpleEntityProxy::class,
            $loader
        );

        /** @var SimpleEntityProxy $proxy */
        $proxy = $proxyFactory->create();
        $root = new SimpleRoot('123', $proxy);

        $loader->schedule(PropertyUpdate::using(
            ScopedHydrator::default(),
            $root,
            'parent.parent.entity'
        ));

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(sprintf(
            'Proxy configuration error: Failed to update the reference to ' .
            'the `%s` after loading it from proxy state: Could not hydrate ' .
            'the `%s`: It has no parent.parent.entity',
            SimpleEntity::class,
            SimpleRoot::class
        ));

        $root->value();
    }
}
