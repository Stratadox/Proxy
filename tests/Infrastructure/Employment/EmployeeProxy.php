<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Infrastructure\Employment;

use Stratadox\Proxy\Proxy;
use Stratadox\Proxy\Proxying;
use Stratadox\Proxy\Test\Domain\Employment\Company;
use Stratadox\Proxy\Test\Domain\Employment\Employee;

final class EmployeeProxy extends Employee implements Proxy
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

    public function position(): ?string
    {
        return $this->_load()->position();
    }

    public function employer(): ?Company
    {
        return $this->_load()->employer();
    }

    public function isIndeed(Employee $other): bool
    {
        return $this->_load()->isIndeed($other);
    }

    public function worksFor(Company $company): bool
    {
        return $this->_load()->worksFor($company);
    }

    public function startWorkingFor(Company $employer): void
    {
        $this->_load()->startWorkingFor($employer);
    }

    public function endEmployment(): void
    {
        $this->_load()->endEmployment();
    }
}
