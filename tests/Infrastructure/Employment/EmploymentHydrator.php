<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Infrastructure\Employment;

use function array_merge;
use Stratadox\Hydrator\Hydrates;
use Stratadox\Hydrator\ObjectHydrator;
use Stratadox\Proxy\Test\Domain\Employment\Company;
use Stratadox\Proxy\Test\Domain\Employment\Employee;

final class EmploymentHydrator implements Hydrates
{
    public function writeTo(object $employee, array $input): void
    {
        if (!$employee instanceof Employee) {
            CanOnlyHydrateEmployments::mustTargetAnEmployee($employee);
        }
        if (!isset($input['employer'])) {
            CanOnlyHydrateEmployments::noEmployerFoundIn($input);
        }
        $employer = $input['employer'];
        if (!$employer instanceof Company) {
            CanOnlyHydrateEmployments::mustReferenceACompany($employer);
        }
        $hydrator = ObjectHydrator::default();
        $hydrator->writeTo($employee, ['employer' => $employer]);
        $hydrator->writeTo($employer, [
            'employees' => array_merge($employer->employees(), [$employee]),
        ]);
    }
}
