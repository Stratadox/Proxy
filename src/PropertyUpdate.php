<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use Stratadox\Hydrator\Hydrates;
use Stratadox\Hydrator\ObjectHydrator;

final class PropertyUpdate implements Update
{
    private $hydrator;
    private $owner;
    private $property;

    private function __construct(
        Hydrates $hydrator,
        object $owner,
        string $property
    ) {
        $this->hydrator = $hydrator;
        $this->owner = $owner;
        $this->property = $property;
    }

    public static function of(object $owner, string $property): self
    {
        return new self(ObjectHydrator::default(), $owner, $property);
    }

    public static function using(
        Hydrates $hydrator,
        object $owner,
        string $property
    ): self {
        return new self($hydrator, $owner, $property);
    }

    public function with(object $instance, array $inputData): void
    {
        $this->hydrator->writeTo($this->owner, [$this->property => $instance]);
    }
}
