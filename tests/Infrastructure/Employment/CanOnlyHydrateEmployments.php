<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Infrastructure\Employment;

use function array_keys;
use function get_class;
use function implode;
use LogicException;
use function sprintf;
use Stratadox\Hydrator\CannotHydrate;

final class CanOnlyHydrateEmployments extends LogicException implements CannotHydrate
{
    public static function mustTargetAnEmployee(object $receivedInstead): CannotHydrate
    {
        return new self(sprintf(
            'Hydration target for this employment hydrator must be an ' .
            'Employee, got %s instead.',
            get_class($receivedInstead)
        ));
    }

    public static function noEmployerFoundIn(array $input): CannotHydrate
    {
        return new self(sprintf(
            'Hydration input for this employment hydrator must contain an ' .
            'entry with the employer, instead got: %s',
            implode(', ', array_keys($input))
        ));
    }

    public static function mustReferenceACompany(object $receivedInstead): CannotHydrate
    {
        return new self(sprintf(
            'Hydration employer input for this employment hydrator must ' .
            'reference a Company, got %s instead.',
            get_class($receivedInstead)
        ));
    }
}
