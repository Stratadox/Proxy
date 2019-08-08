<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Infrastructure\FinalConstructor;

use function json_encode;
use LogicException;
use Stratadox\Proxy\ProxyLoader;
use Stratadox\Proxy\Test\Domain\FinalConstructor\FinalConstructor;

final class FinalConstructorLoader implements ProxyLoader
{
    private $objects;

    public function __construct(FinalConstructor ...$objects)
    {
        $this->objects = $objects;
    }

    public function loadTheInstance(array $data): object
    {
        foreach ($this->objects as $object) {
            if ($object->value() === $data['value']) {
                return $object;
            }
        }
        throw new LogicException('No object found for ' . json_encode($data));
    }
}
