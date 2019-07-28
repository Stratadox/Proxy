<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use function get_class;
use LogicException;
use function sprintf;
use Stratadox\Hydrator\CannotHydrate;

final class CouldNotUpdateReference extends LogicException implements UpdateFailure
{
    public static function failedToUpdate(
        object $instance,
        CannotHydrate $exception
    ): self {
        return new self(sprintf(
            'Failed to update the reference to the `%s` after loading it ' .
            'from proxy state: %s',
            get_class($instance),
            $exception->getMessage()
        ));
    }
}
