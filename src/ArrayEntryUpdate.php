<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use function get_class;
use ReflectionException;
use ReflectionProperty;
use Stratadox\Specification\Contract\Satisfiable;

final class ArrayEntryUpdate implements Update
{
    private $owner;
    private $offset;
    private $property;
    private $condition;

    private function __construct(
        object $owner,
        string $offset,
        ReflectionProperty $property,
        Satisfiable $condition
    ) {
        $this->owner = $owner;
        $this->offset = $offset;
        $this->property = $property;
        $this->property->setAccessible(true);
        $this->condition = $condition;
    }

    /** @throws ReflectionException When owner inherits or misses property */
    public static function of(object $owner, string $property, $offset, Satisfiable $condition): self
    {
        return new self(
            $owner,
            (string) $offset,
            new ReflectionProperty(get_class($owner), $property),
            $condition
        );
    }

    public function with(object $instance, array $inputData): void
    {
        if (!$this->condition->isSatisfiedBy($inputData)) {
            return;
        }
        $array = $this->property->getValue($this->owner);
        $array[$this->offset] = $instance;
        $this->property->setValue($this->owner, $array);
    }
}
