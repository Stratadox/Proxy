<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use Stratadox\Deserializer\DeserializationFailure;
use Stratadox\Deserializer\Deserializer;

final class DeserializingProxyFactory implements ProxyFactory
{
    /** @var Deserializer */
    private $deserializer;
    /** @var ProxyLoader */
    private $loader;

    private function __construct(Deserializer $deserializer, ProxyLoader $loader)
    {
        $this->deserializer = $deserializer;
        $this->loader = $loader;
    }

    public static function using(
        Deserializer $deserializer,
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
        } catch (DeserializationFailure $exception) {
            throw ProxyDeserializationFailed::encountered($exception);
        }
    }
}
