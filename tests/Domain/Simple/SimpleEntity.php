<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Domain\Simple;

class SimpleEntity
{
    private $id;
    private $attribute;

    private function __construct(string $id, SimpleValue $attribute)
    {
        $this->id = $id;
        $this->attribute = $attribute;
    }

    public static function withIdAndAttribute(string $id, string $attribute): self
    {
        return new self($id, SimpleValue::withValue($attribute));
    }

    public function id(): string
    {
        return $this->id;
    }

    public function attribute(): SimpleValue
    {
        return $this->attribute;
    }

    public function changeAttribute(SimpleValue $attribute): void
    {
        $this->attribute = $attribute;
    }

    public function equals(SimpleEntity $other): bool
    {
        return $this->id() === $other->id();
    }
}
