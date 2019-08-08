<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use Stratadox\Deserializer\CannotDeserialize;
use Stratadox\Deserializer\Deserializes;

final class DeserializingProxyFactory implements ProxyFactory
{
    private $deserializer;
    private $loader;

    private function __construct(Deserializes $deserializer, ProxyLoader $loader)
    {
        $this->deserializer = $deserializer;
        $this->loader = $loader;
    }

    public static function using(
        Deserializes $deserializer,
        ProxyLoader $loader
    ): ProxyFactory {
        return new self($deserializer, $loader);
    }

    /** @inheritdoc */
    public function create(array $knownData = []): Proxy
    {
        try {
            return $this->deserializer->from([
                'loader' => $this->loader,
                'knownData' => $knownData,
            ]);
        } catch (CannotDeserialize $exception) {
            throw ProxyDeserializationFailed::encountered($exception);
        }
    }
}
