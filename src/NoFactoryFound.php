<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use function json_encode;
use LogicException;
use function sprintf;

/**
 * NoFactoryFound. Exception thrown when none of the proxy factory choices are
 * applicable to the known data.
 *
 * @author Stratadox
 */
final class NoFactoryFound extends LogicException implements ProxyProductionFailed
{
    /**
     * Indicates that none of the factories are acceptable given the input data.
     *
     * @param array $knownData The data that was given.
     * @return NoFactoryFound  The exception to throw.
     */
    public static function forData(array $knownData): self
    {
        return new self(sprintf(
            'None of the proxy factories is configured to load the data: %s',
            json_encode($knownData)
        ));
    }
}
