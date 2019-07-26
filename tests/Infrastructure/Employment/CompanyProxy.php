<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Infrastructure\Employment;

use Stratadox\Proxy\Proxy;
use Stratadox\Proxy\Proxying;
use Stratadox\Proxy\Test\Domain\Employment\Company;
use Stratadox\Proxy\Test\Domain\Employment\Employee;

final class CompanyProxy extends Company implements Proxy
{
    use Proxying;

    public function id(): string
    {
        return $this->_load()->id();
    }

    public function name(): string
    {
        return $this->_load()->name();
    }

    public function employees(): array
    {
        return $this->_load()->employees();
    }

    public function employs(Employee $theOneWeAreLookingFor): bool
    {
        return $this->_load()->employs($theOneWeAreLookingFor);
    }

    public function rename(string $newName): void
    {
        $this->_load()->rename($newName);
    }

    public function hire(Employee $employee): void
    {
        $this->_load()->hire($employee);
    }

    public function fire(Employee $exEmployee): void
    {
        $this->_load()->fire($exEmployee);
    }

    public function notifyResignationOf(Employee $exEmployee): void
    {
        $this->_load()->notifyResignationOf($exEmployee);
    }
}
