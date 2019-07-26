<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use Stratadox\Hydrator\CannotHydrate;
use Stratadox\Hydrator\Hydrates;
use Stratadox\Hydrator\ObjectHydrator;

final class PropertyUpdate
{
    private $hydrator;
    private $owner;
    private $property;
    private static $defaultHydrator;

    private function __construct(
        Hydrates $hydrator,
        object $owner,
        string $property
    ) {
        $this->hydrator = $hydrator;
        $this->owner = $owner;
        $this->property = $property;
    }

    private static function hydrator(): Hydrates
    {
        if (null === self::$defaultHydrator) {
            self::$defaultHydrator = ObjectHydrator::default();
        }
        return self::$defaultHydrator;
    }

    public static function of(object $owner, string $property): self
    {
        return new self(self::hydrator(), $owner, $property);
    }

    public static function using(
        Hydrates $hydrator,
        object $owner,
        string $property
    ): self {
        return new self($hydrator, $owner, $property);
    }

    /** @throws CannotHydrate */
    public function with(object $instance): void
    {
        $this->hydrator->writeTo($this->owner, [$this->property => $instance]);
    }
}
