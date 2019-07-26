<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test;

use PHPUnit\Framework\TestCase;
use Stratadox\Proxy\PropertyUpdate;
use Stratadox\Proxy\Proxy;
use Stratadox\Proxy\BasicProxyFactory;
use Stratadox\Proxy\Test\Domain\Employment\Employee;
use Stratadox\Proxy\Test\Infrastructure\Employment\CompanyLoader;
use Stratadox\Proxy\Test\Infrastructure\Employment\CompanyProxy;
use Stratadox\Proxy\Test\Infrastructure\Employment\EmploymentHydrator;
use Stratadox\Proxy\Test\Support\PropertyProbing;
use Stratadox\Proxy\UpdatingLoader;

/**
 * @testdox Updating multiple references at a time upon loading
 */
class Updating_multiple_custom_references extends TestCase
{
    use PropertyProbing;

    /** @test */
    function only_updating_the_references_after_the_proxy_got_loaded()
    {
        $loader = UpdatingLoader::using(new CompanyLoader());
        $proxyFactory = BasicProxyFactory::for(CompanyProxy::class, $loader);

        /** @var CompanyProxy $proxy */
        $proxy = $proxyFactory->create();
        $jane = new Employee('1', 'Jane Doe', 'Contractor', $proxy);
        $john = new Employee('2', 'John Doe', 'Contractor', $proxy);

        $loader->schedule(PropertyUpdate::of($jane, 'employer'));
        $loader->schedule(PropertyUpdate::of($john, 'employer'));

        $this->assertInstanceOf(
            Proxy::class,
            $this->valueOf(Employee::class, $jane, 'employer')
        );
        $this->assertInstanceOf(
            Proxy::class,
            $this->valueOf(Employee::class, $john, 'employer')
        );
    }

    /** @test */
    function updating_the_reference_after_the_proxy_got_loaded()
    {
        $loader = UpdatingLoader::using(new CompanyLoader());
        $updater = new EmploymentHydrator();
        $proxyFactory = BasicProxyFactory::for(CompanyProxy::class, $loader);

        /** @var CompanyProxy $proxy */
        $proxy = $proxyFactory->create();
        $jane = new Employee('1', 'Jane Doe', 'Manager', $proxy);
        $john = new Employee('2', 'John Doe', 'Manager', $proxy);
        $joffrey = new Employee('3', 'Joffrey Lannister', 'King');

        $loader->schedule(PropertyUpdate::using($updater, $jane, 'employer'));
        $loader->schedule(PropertyUpdate::using($updater, $john, 'employer'));

        $this->assertTrue($proxy->employs($jane));
        $this->assertTrue($proxy->employs($john));
        $this->assertFalse($proxy->employs($joffrey));
    }
}
