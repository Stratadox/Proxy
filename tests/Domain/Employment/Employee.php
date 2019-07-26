<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Domain\Employment;

use RuntimeException;

/**
 * Best to avoid bi-directional associations in practice.
 */
class Employee
{
    private $id;
    private $name;
    private $position;
    private $employer;

    public function __construct(
        string $id,
        string $name,
        string $position = null,
        Company $employer = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->position = $position;
        $this->employer = $employer;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function position(): ?string
    {
        return $this->position;
    }

    public function employer(): ?Company
    {
        return $this->employer;
    }

    public function isIndeed(Employee $other): bool
    {
        return $this->id() === $other->id();
    }

    public function worksFor(Company $company): bool
    {
        return $this->employer !== null && $this->employer->isSameAs($company);
    }

    public function startWorkingFor(Company $employer): void
    {
        if ($this->employer !== null) {
            throw new RuntimeException(
                'Cannot work for multiple employers at a time'
            );
        }
        $this->employer = $employer;
    }

    public function endEmployment(): void
    {
        if ($this->employer === null) {
            throw new RuntimeException(
                'Need an employer in order to resign'
            );
        }
        $thisEmployee = $this;
        if ($this->employer->employs($thisEmployee)) {
            $this->employer->notifyResignationOf($thisEmployee);
        }
        $this->employer = null;
    }
}
