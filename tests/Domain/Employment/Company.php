<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Domain\Employment;

use RuntimeException;

/**
 * Best to avoid bi-directional associations in practice.
 */
class Company
{
    private $id;
    private $name;
    private $employees;

    public function __construct(string $id, string $name, Employee ...$employees)
    {
        $this->id = $id;
        $this->name = $name;
        $this->employees = $employees;
        $thisCompany = $this;
        foreach ($employees as $employee) {
            if (!$employee->worksFor($thisCompany)) {
                $employee->startWorkingFor($thisCompany);
            }
        }
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function employees(): array
    {
        return $this->employees;
    }

    public function isSameAs(Company $other): bool
    {
        return $this->id() === $other->id();
    }

    public function employs(Employee $theOneWeAreLookingFor): bool
    {
        foreach ($this->employees as $ourEmployee) {
            if ($ourEmployee->isIndeed($theOneWeAreLookingFor)) {
                return true;
            }
        }
        return false;
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }

    public function hire(Employee $employee): void
    {
        $employee->startWorkingFor($this);
        $this->employees[] = $employee;
    }

    public function fire(Employee $exEmployee): void
    {
        if (!$this->employs($exEmployee)) {
            throw new RuntimeException(
                'Cannot fire someone who does not work here'
            );
        }
        $this->removeFromCurrentEmployees($exEmployee);
        $exEmployee->endEmployment();
    }

    public function notifyResignationOf(Employee $exEmployee): void
    {
        if (!$this->employs($exEmployee)) {
            throw new RuntimeException(
                'Cannot resign without first working there'
            );
        }
        $this->removeFromCurrentEmployees($exEmployee);
    }

    private function removeFromCurrentEmployees(Employee $exEmployee): void
    {
        foreach ($this->employees as $i => $employee) {
            if ($employee->isIndeed($exEmployee)) {
                unset($this->employees[$i]);
            }
        }
    }
}
