<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use function json_encode;
use LogicException;
use function sprintf;

/**
 * NoFactoryFound.
 *
 * @author Stratadox
 */
final class NoFactoryFound extends LogicException implements ProxyProductionFailed
{
    public static function forData(array $knwownData): self
    {
        return new self(sprintf(
            'None of the proxy factories is configured to load the data: %s',
            json_encode($knwownData)
        ));
    }
}
