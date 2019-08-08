<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use LogicException;
use Stratadox\Deserializer\CannotDeserialize;

final class ProxyDeserializationFailed extends LogicException implements ProxyProductionFailed
{
    public static function encountered(
        CannotDeserialize $exception
    ): ProxyProductionFailed {
        return new self(sprintf(
            'Could not deserialize the proxy instance: %s',
            $exception->getMessage()
        ), $exception->getCode(), $exception);
    }
}
